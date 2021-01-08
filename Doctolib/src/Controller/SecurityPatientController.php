<?php

namespace App\Controller;

use App\Entity\Patient;
use App\Form\InscriptionPatientType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityPatientController extends AbstractController
{
    /**
     * @Route("/security/inscriptionPatient", name="inscriptionPatient_security")
     */
    public function signin(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder){
        $patient = new Patient();
        $formPatient=$this->createForm(InscriptionPatientType::class, $patient);
        $formPatient->handleRequest($request);
        if($formPatient->isSubmitted() && $formPatient->isValid()){
            $hash= $encoder->encodePassword($patient, $patient->getPassword());
            $patient->setPassword($hash);
            $manager->persist($patient);
            $manager->flush();
            
            return $this->redirectToRoute('app_login');
        }
        return $this->render('security/inscriptions.html.twig', [
            'formPatient' => $formPatient->createView()
        ]);
    }
    
    
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/loginPatient.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}

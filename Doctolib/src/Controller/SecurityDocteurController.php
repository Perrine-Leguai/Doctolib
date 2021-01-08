<?php

namespace App\Controller;

use App\Entity\Docteur;
use App\Form\InscriptionDocteurType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityDocteurController extends AbstractController
{
    /**
     * @Route("/security/inscriptionDocteur", name="inscriptionDocteur_security")
     */
    public function signin(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder){
        $docteur = new Docteur();
        $formDoc=$this->createForm(InscriptionDocteurType::class, $docteur);
        $formDoc->handleRequest($request);
        if($formDoc->isSubmitted() && $formDoc->isValid()){
            $hash= $encoder->encodePassword($docteur, $docteur->getPassword());
            $docteur->setPassword($hash);
            $manager->persist($docteur);
            $manager->flush();
            
            return $this->redirectToRoute('app_login');
        }
        return $this->render('security/inscriptions.html.twig', [
            'formDocteur' => $formDoc->createView()
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

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}

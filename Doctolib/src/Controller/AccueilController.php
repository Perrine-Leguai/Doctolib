<?php

namespace App\Controller;

use App\Repository\DocteurRepository;
use App\Repository\PatientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccueilController extends AbstractController
{
    public function __construct(PatientRepository $repositoryPatient, DocteurRepository $repositoryDocteur, EntityManagerInterface $manager){
            $this->repositoryP = $repositoryPatient;
            $this->repositoryD = $repositoryDocteur;

            $this->manager=$manager;
    }
    
    /**
     * @Route("/accueil", name="pageAccueil_accueil")
     */
    public function infoAccueil(): Response
    {
        
        $nbrPatients= count($this->repositoryP->findAll());
        $nbrDocteurs= count($this->repositoryD->findAll());

        return $this->render('accueil/pageAccueilHorsCo.html.twig', [
            'controller_name' => 'AccueilController',
            'nombre_de_patients' =>$nbrPatients,
            'nombre_de_docteurs' =>$nbrDocteurs,
        ]);
    }
}

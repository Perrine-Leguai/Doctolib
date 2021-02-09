<?php

namespace App\Service;

use App\Entity\PriseRdv;
use App\Mapper\PriseRdvMapper;
use App\Repository\DocteurRepository;
use App\Repository\PatientRepository;
use App\Repository\PriseRdvRepository;
use Doctrine\ORM\EntityManagerInterface;

//penser à mettre à jour les interfaces aussi

class PriseRdvService {
    private $entityManager;
    private $patientRdvRepository;
    private $docteurRepository;
    private $priseRdvRepository;
    private $priseRdvMapper;
    

    public function __construct(EntityManagerInterface $manager, PriseRdvMapper $mapper, PatientRepository $patientRepository, PriseRdvRepository  $priseRdvRepository, DocteurRepository $docteurRepository){

        $this->entityManager        = $manager;
        $this->priseRdvMapper       = $mapper;
        $this->priseRdvRepository   = $priseRdvRepository;
        $this->patientRepository    = $patientRepository;
        $this->docteurRepository = $docteurRepository;
    }

    

    public function searchById(int $id, $session){
        try{
            if($session=='PATIENT'){
                $priseRdvs = $this->priseRdvRepository->findBy( ["idPatient" => $id]);
            }
            if($session=='DOCTEUR'){
                $priseRdv = $this->priseRdvRepository->findBy( ["id_docteur" => $id]);
            }
            foreach($priseRdvs as $rdv){
                $priseRdvPatientsouDocteurs[]=$this->priseRdvMapper->transformeEntityToPriseRdvDto($rdv);
            }
            return $priseRdvPatientsouDocteurs ;
        }catch(DriverException $e){
            throw new PriseRdvServiceException("un pb technique est arrivé");
        }
    }
    
    
    public function delete(PriseRdv $priseRdv){
        try{
            $this->entityManager->remove($priseRdv);
            $this->entityManager->flush();

        }catch(DriverException $e){
            throw new PriseRdvServiceException("un pb technique est arrivé");
        }
    }
   
    public function persist($priseRdv, $priseRdvDTO){
        try{
            $docteurId=$priseRdvDTO->getIdDocteur();
            $docteur=$this->docteurRepository->find($docteurId);
           
            
            $patientId=$priseRdvDTO->getIdPatient();
            $patient=$this->patientRepository->find($patientId);
            
            $priseRdv= $this->priseRdvMapper->transformePriseRdvDtoToEntity($priseRdvDTO, $priseRdv, $patient,$docteur);
            $this->entityManager->persist($priseRdv);
            $this->entityManager->flush();
        }catch(DriverException $e){
            throw new PriseRdvServiceException("un pb technique est arrivé");
        }
    }

    public function searchAll(){
        try{
            $priseRdvs=$this->priseRdvRepository->findAll();
            //transformation de l'ensemble des PriseRdvs
            $priseRdvsDTO = [];
            foreach($priseRdvs as $priseRdv){
               $priseRdvsDTO[]= $this->priseRdvMapper->transformeEntityToPriseRdvDto($priseRdv);
            }
            return $priseRdvsDTO;
        }catch(DriverException $e){
            throw new priseRdvServiceException("un pb technique est arrivé");
        }
    }

}


<?php

namespace App\Service;

use App\Entity\Patient;
use App\Mapper\PatientMapper;
use App\Repository\PatientRepository;
use App\Repository\PriseRdvRepository;
use App\Repository\SpecialiteRepository;
use Doctrine\ORM\EntityManagerInterface;

//penser à mettre à jour les interfaces aussi

class PatientService {
    private $entityManager;
    private $patientRepository;
    private $priseRdvRepository;
    private $patientMapper;
    

    public function __construct(EntityManagerInterface $manager, PatientMapper $mapper, patientRepository $patientRepository, PriseRdvRepository $priseRdvRepository){

        $this->entityManager        = $manager;
        $this->patientMapper        = $mapper;
        $this->patientRepository    = $patientRepository;
        $this->priseRdvRepository   = $priseRdvRepository;
    }

    public function searchAll(){
        try{
            $patients=$this->patientRepository->findAll();
            //transformation de l'ensemble des patients
            $patientsDTO = [];
            foreach($patients as $patient){
               $patientsDTO[]= $this->patientMapper->transformeEntityToPatientDto($patient);
            }
            return $patientsDTO;
        }catch(DriverException $e){
            throw new PatientServiceException("un pb technique est arrivé");
        }
    }

    
    public function searchById(int $id){
            try{
                $patient = $this->patientRepository->find($id);
                return  $this->patientMapper->transformeEntityToPatientDto($patient);
            }catch(DriverException $e){
                throw new PatientServiceException("un pb technique est arrivé");
            }
        }


    public function delete(Patient $patient){
        try{
            $this->entityManager->remove($patient);
            $this->entityManager->flush();

        }catch(DriverException $e){
            throw new PatientServiceException("un pb technique est arrivé");
        }
    }

    //permet de créer un nouveau Patient ET de faire les mises à jour
    public function persist(){
        try{
            $specialiteIds[]=$patientDTO->getSpecialite();
            foreach ($specialiteIds as $specialiteId){
                $specialites[]=$this->specialiteRepository->find($specialiteId);
            }
            $priseRdvIds[]=$patientDTO->getPriseRdv();
            foreach ($priseRdvIds as $PriseRdvId){
                $priserdvs[]=$this->specialiteRepository->find($priseRdvIds);
            }

            $priseRdvs = $this->priserdvRepository->find($patientDTO->getPriseRdvs());
            $patient= $this->patientMapper->transformePatientDtoToPatientEntity($patientDTO, $patient, $specialites, $priseRdvs);
            $this->entityManager->persist($patient);
            $this->entityManager->flush();
        }catch(DriverException $e){
            throw new PatientServiceException("un pb technique est arrivé");
        }
    }

    
    

}


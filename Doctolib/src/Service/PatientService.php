<?php

namespace App\Service;

use App\Entity\Patient;
use App\Mapper\DocteurMapper;
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
    private $docteurMapper;
    

    public function __construct(EntityManagerInterface $manager, PatientMapper $mapper, patientRepository $patientRepository, PriseRdvRepository $priseRdvRepository, DocteurMapper $docteurMapper){

        $this->entityManager        = $manager;
        $this->patientMapper        = $mapper;
        $this->patientRepository    = $patientRepository;
        $this->priseRdvRepository   = $priseRdvRepository;
        $this->docteurMapper        = $docteurMapper;
    }

    public function searchAllDocteurs($id){
        try{
            $patient=$this->patientRepository->find($id);
            $rdvs= $patient->getPriseRdvs();
            foreach($rdvs as $rdv){
               $docteurs[]= $this->docteurMapper->transformeEntityToDocteurDto($rdv->getIdDocteur());
            }
            return $docteurs;
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
    public function persist($patient, $patientDTO){
        try{
            
            $patient= $this->patientMapper->transformePatientDtoToPatientEntity($patientDTO, $patient);
            $this->entityManager->persist($patient);
            $this->entityManager->flush();
        }catch(DriverException $e){
            throw new PatientServiceException("un pb technique est arrivé");
        }
    }

}

//public function searchByIdDocteur(int $id){
    //         try{
    //             $rdvDoc = $this->priseRdvRepository->findBy(["id_docteur" => "$id"]);
    //         foreach($rdvDoc as $rdv){
    //             $patient = $this->patientRepository->find($rdv->getIdPatient());
    //             $patients[] = $this->patientMapper->transformeEntityToPatientDto($patient);
    //         }
    //             return  $patient;
    //         }catch(DriverException $e){
    //             throw new PatientServiceException("un pb technique est arrivé");
    //         }
    //     }
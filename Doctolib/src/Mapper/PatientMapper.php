<?php
//quid des specialite et prise de rdvs qui sont des tableaux ?
namespace App\Mapper;

use App\DTO\PatientDTO;
use App\Entity\Patient;
use App\Entity\PriseRdv;
use App\Entity\Specialite;

class PatientMapper{

    //permet de traduire en php les informations reçues en POST, Json
    public function transformePatientDtoToPatientEntity(PatientDTO $patientDTO, Patient $patient){
        
        $patient->setUsername($patientDTO->getUsername())
                ->setPassword($patientDTO->getPassword())
                ->setNumeroCarteVitale($patientDTO->getNumeroCarteVitale())
                ->setNom($patientDTO->getNom())
                ->setPrenom($patientDTO->getPrenom())
                ->setAdresse($patientDTO->getAdresse())
                ->setVille($patientDTO->getVille())
                ->setCodePostal($patientDTO->getCodePostal())
                ->setEmail($patientDTO->getEmail())
                ->setTelephone($patientDTO->getTelephone());
                

    //est-ce qu'on envoie un tableau dans la fonction et pour each specialites as specialite on fait un setSpecialite ?
    //mm questionnement pour priserdvs
        return $patient;
    }

    //permet de traduire en Json les informations envoyées en POST depuis l'API
    public function transformeEntityToPatientDto(Patient $patient){
      
        $patientDTO = new PatientDTO();
        $patientDTO ->setId($patient->getId())
                    ->setUsername($patient->getUsername())
                    ->setNumeroCarteVitale($patient->getNumeroCarteVitale())
                    ->setNom($patient->getNom())
                    ->setPrenom($patient->getPrenom())
                    ->setAdresse($patient->getAdresse())
                    ->setVille($patient->getVille())
                    ->setCodePostal($patient->getCodePostal())
                    ->setEmail($patient->getEmail())
                    ->setTelephone($patient->getTelephone());
                    
        
        return$patientDTO;
    }
}
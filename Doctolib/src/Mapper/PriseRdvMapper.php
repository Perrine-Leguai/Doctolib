<?php
//quid des specialite et prise de rdvs qui sont des tableaux ?
namespace App\Mapper;

use App\DTO\PriseRdvDTO;
use App\Entity\PriseRdv;
use App\Entity\Docteur;
use App\Entity\Patient;

class PriseRdvMapper{

    //permet de traduire en php les informations reçues en POST, Json
    public function transformePriseRdvDtoToEntity(PriseRdvDTO $priseRdvDTO, PriseRdv $priseRdv,Patient  $patient,Docteur $docteur){
        
        $priseRdv   ->setDate(new \DateTime($priseRdvDTO->getDate()))
                    ->setIdDocteur($docteur)
                    ->setIdPatient($patient);

    
        return $priseRdv;
    }

    //permet de traduire en Json les informations envoyées en POST depuis l'API
    public function transformeEntityToPriseRdvDto(PriseRdv $priseRdv){
        
        $docteurs=[ ($priseRdv->getIdDocteur())->getNom(),
                    ($priseRdv->getIdDocteur())->getPrenom(), 
                    ($priseRdv->getIdDocteur())->getTelephone()];
        
        $patients=[ ($priseRdv->getIdPatient())->getNom(),
                    ($priseRdv->getIdPatient())->getPrenom(),
                    ($priseRdv->getIdPatient())->getTelephone()];
        
        $priseRdvDTO = new PriseRdvDTO();
        $priseRdvDTO    ->setId($priseRdv->getId())
                        ->setDate($priseRdv->getDate())
                        ->setIdDocteur($docteurs)
                        ->setIdPatient($patients);
                    
        
        return$priseRdvDTO;
    }
}
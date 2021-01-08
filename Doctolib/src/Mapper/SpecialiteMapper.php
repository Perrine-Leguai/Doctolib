<?php
//quid des specialite et prise de rdvs qui sont des tableaux ?
namespace App\Mapper;

use App\DTO\SpecialiteDTO;
use App\Entity\Specialite;
use App\Entity\Docteur;


class SpecialiteMapper{

    //permet de traduire en php les informations reçues en POST, Json
    public function transformeSpecialiteDtoToEntity(SpecialiteDTO $specialiteDTO, Specialite $specialite,  $docteurs){
       
        $specialite ->setNom($specialiteDTO->getNom());
        foreach($docteurs as $docteur){
            $specialite->addDocteur($docteur);
        }
        
        return $specialite;
    }

    
    //permet de traduire en Json les informations envoyées en POST depuis l'API
    public function transformeEntityToSpecialiteDto(Specialite $specialite){
        
        //récupère tous les ids des docs
        $docteurs=$specialite->getDocteurs();
        $idsDocteur[]=0;
        foreach($docteurs as $docteur){
            $idsDocteur[]=$docteur->getId();
        }

        $specialiteDTO = new SpecialiteDTO();
        $specialiteDTO  ->setId($specialite->getId())
                        ->setNom($specialite->getNom())
                        ->setDocteurs($idsDocteur);
                    
        return$specialiteDTO;
    }
}
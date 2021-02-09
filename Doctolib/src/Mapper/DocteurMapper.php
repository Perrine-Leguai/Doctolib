<?php
//quid des specialite et prise de rdvs qui sont des tableaux ?
namespace App\Mapper;

use App\DTO\DocteurDTO;
use App\Entity\Docteur;
use App\Entity\PriseRdv;
use App\Entity\Specialite;

class DocteurMapper{

    //permet de traduire en php les informations reçues en POST, Json
    public function transformeDocteurDtoToDocteurEntity(DocteurDTO $docteurDTO, Docteur $docteur, $specialite){ 
        
        $docteur->setUsername($docteurDTO->getUsername())
                ->setPassword($docteurDTO->getPassword())
                ->setNumeroOrdre($docteurDTO->getNumeroOrdre())
                ->setNom($docteurDTO->getNom())
                ->setPrenom($docteurDTO->getPrenom())
                ->setAdresseTravail($docteurDTO->getAdresseTravail())
                ->setCodePostal($docteurDTO->getCodePostal())
                ->setVille($docteurDTO->getVille())
                ->setEmail($docteurDTO->getEmail())
                ->setTelephone($docteurDTO->getTelephone())
                ->setLienSiteInternet($docteurDTO->getLienSiteInternet());
        if(!empty($specialite)){
            foreach( $specialite as $spe){
                $docteur->addSpecialite($spe);
            } 
        }
        
                
              

    //est-ce qu'on envoie un tableau dans la fonction et pour each specialites as specialite on fait un setSpecialite ?

        return $docteur;
    }

    //permet de traduire en Json les informations envoyées en POST depuis l'API
    public function transformeEntityToDocteurDto(Docteur $docteur){
        //récupère toutes les specialites
        $specialites=$docteur->getSpecialites();
        foreach($specialites as $specialite){
            //tableau des id de spécialités
            $idsSpecialite[]=$specialite->getId();
        }



        $docteurDto = new DocteurDTO();
        $docteurDto ->setId($docteur->getId())
                    ->setnumeroOrdre($docteur->getNumeroOrdre())
                    ->setNom($docteur->getNom())
                    ->setPrenom($docteur->getPrenom())
                    ->setAdresseTravail($docteur->getAdresseTravail())
                    ->setCodePostal($docteur->getCodePostal())
                    ->setVille($docteur->getVille())
                    ->setEmail($docteur->getEmail())
                    ->setTelephone($docteur->getTelephone())
                    ->setLienSiteInternet($docteur->getLienSiteInternet())
                    ->setSpecialites($idsSpecialite)
                    ->setUsername($docteur->getUsername())
                    ->setPassword($docteur->getPassword());
                    
        return$docteurDto;
    }
}
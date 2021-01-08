<?php
//quid des specialite et prise de rdvs qui sont des tableaux ?
namespace App\Mapper;

use App\DTO\DocteurDTO;
use App\Entity\Docteur;
use App\Entity\PriseRdv;
use App\Entity\Specialite;

class DocteurMapper{

    //permet de traduire en php les informations reçues en POST, Json
    public function transformeDocteurDtoToDocteurEntity(DocteurDTO $docteurDTO, Docteur $docteur){ //$specialite,  $priseRdv){
        
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
                ->setLienSiteInternet($docteurDTO->getLienSiteInternet())
                ->addSpecialite(25);
                // ->addSpecialite($specialite)
                // ->addPriseRdv($priserdv);

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

        //récupère tous les rdvs
        $priserdvs=$docteur->getPriseRdvs();
        foreach($priserdvs as $priserdv){
            $idsPriseRdvs[]=$priserdv->getId();
        }


        $docteurDto = new DocteurDTO();
        $docteurDto ->setId($docteur->getId())
                    ->setUsername($docteur->getUsername())
                    ->setPassword($docteur->getPassword())
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
                    ->setPriseRdvs($idsPriseRdvs);
                    
        
        return$docteurDto;
    }
}
<?php

namespace App\Service;

use App\Entity\Docteur;
use App\Entity\Specialite;
use App\Mapper\DocteurMapper;
use App\Mapper\SpecialiteMapper;
use App\Repository\DocteurRepository;
use App\Repository\SpecialiteRepository;
use Doctrine\ORM\EntityManagerInterface;

//penser à mettre à jour les interfaces aussi

class SpecialiteService {
    private $entityManager;
    private $specialiteRepository;
    private $specialiteMapper;
    

    public function __construct(EntityManagerInterface $manager, SpecialiteMapper $mapper, SpecialiteRepository $specialiteRepository, DocteurRepository $docteurRepository, DocteurMapper $docteurMapper){

        $this->entityManager        = $manager;
        $this->specialiteMapper     = $mapper;
        $this->specialiteRepository = $specialiteRepository;
        $this->docteurRepository    = $docteurRepository;
        $this->docteurMapper        = $docteurMapper;
    }

    public function searchAll(){
        try{
            $specialites=$this->specialiteRepository->findAll();
            //transformation de l'ensemble des specialites
            $specialitesDTO = [];
            foreach($specialites as $specialite){
               $specialitesDTO[]= $this->specialiteMapper->transformeEntityToSpecialiteDto($specialite);
            }
            return $specialitesDTO;
        }catch(DriverException $e){
            throw new SpecialiteServiceException("un pb technique est arrivé");
        }
    } 

    public function searchById(int $id){
        try{
            $specialite = $this->specialiteRepository->find($id);
            return  $this->specialiteMapper->transformeEntityToSpecialiteDto($specialite);
        }catch(DriverException $e){
            throw new SpecialiteServiceException("un pb technique est arrivé");
        }
    }
    
    public function searchBySpecialite( $specialite){
        try{
            $spe=$this->specialiteRepository->findOneBy(["nom" => $specialite]);
            $docteurs= $spe->getDocteurs();
            foreach($docteurs as $docteur){
                
                $doc=$this->docteurRepository->find($docteur->getId());
                $docs[]= $this->docteurMapper->transformeEntityToDocteurDto($doc);
             }
            return $docs ;
        }catch(DriverException $e){
            throw new DocteurServiceException("un pb technique est arrivé");
        }
    }  

    public function delete(Specialite $specialite){
        try{
            $this->entityManager->remove($specialite);
            $this->entityManager->flush();

        }catch(DriverException $e){
            throw new SpecialiteServiceException("un pb technique est arrivé");
        }
    }

    //permet de créer un nouveau Specialite ET de faire les mises à jour
    public function persist($specialite, $specialiteDTO){
        try{
            $docteurIds[]=$specialiteDTO->getDocteurs();
            foreach ($docteurIds as $docteurId){
                foreach($docteurId as $dId){
                    $docteurs[]=$this->docteurRepository->find($dId);
                }
            }
            
            $specialite= $this->specialiteMapper->transformeSpecialiteDtoToEntity($specialiteDTO, $specialite, $docteurs);
            $this->entityManager->persist($specialite);
            $this->entityManager->flush();
        }catch(DriverException $e){
            throw new SpecialiteServiceException("un pb technique est arrivé");
        }
    }
}

    
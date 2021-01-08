<?php

namespace App\Service;

use App\DTO\DocteurDTO;
use App\Entity\Docteur;
use App\Mapper\DocteurMapper;
use App\Repository\DocteurRepository;
use App\Repository\PriseRdvRepository;
use App\Repository\SpecialiteRepository;
use Doctrine\ORM\EntityManagerInterface;

//penser à mettre à jour les interfaces aussi

class DocteurService {
    private $entityManager;
    private $repo;
    private $specialiteRepository;
    private $priseRdvRepository;
    private $docteurMapper;
    

    public function __construct(EntityManagerInterface $manager, DocteurMapper $mapper, DocteurRepository $docteurRepository, SpecialiteRepository $specialiteRepostory, PriseRdvRepository $priseRdvRepository){

        $this->entityManager        = $manager;
        $this->docteurMapper        = $mapper;
        $this->docteurRepository    = $docteurRepository;
        $this->specialiteRepository = $specialiteRepostory;
        $this->priseRdvRepository   = $priseRdvRepository;
    }

    public function searchAll(){
        try{
            $docteurs=$this->docteurRepository->findAll();
            //transformation de l'ensemble des Docteurs
            $docteursDTO = [];
            foreach($docteurs as $docteur){
               $docteursDTO[]= $this->docteurMapper->transformeEntityToDocteurDto($docteur);
            }
            return $docteursDTO;
        }catch(DriverException $e){
            throw new DocteurServiceException("un pb technique est arrivé");
        }
    }

    
    public function searchById(int $id){
            try{
                $docteur = $this->docteurRepository->find($id);
                return  $this->docteurMapper->transformeEntityToDocteurDto($docteur);
            }catch(DriverException $e){
                throw new DocteurServiceException("un pb technique est arrivé");
            }
        }


    public function delete(Docteur $docteur){
        try{
            $this->entityManager->remove($docteur);
            $this->entityManager->flush();

        }catch(DriverException $e){
            throw new DocteurServiceException("un pb technique est arrivé");
        }
    }

    //permet de créer un nouveau docteur ET de faire les mises à jour
    public function persist(Docteur $docteur, DocteurDTO $docteurDTO){
        try{
            $specialiteIds[]=$docteurDTO->getSpecialites();
            foreach ($specialiteIds as $specialiteId){
                $specialites[]=$this->specialiteRepository->find($specialiteId);
            }
            $priseRdvIds[]=$docteurDTO->getPriseRdvs();
            foreach ($priseRdvIds as $priseRdvId){
                $priserdvs[]=$this->priseRdvRepository->find($priseRdvId);
            }

            $docteur= $this->docteurMapper->transformeDocteurDtoToDocteurEntity($docteurDTO, $docteur); //, $specialites, $priseRdvs);
            $this->entityManager->persist($docteur);
            $this->entityManager->flush();
        }catch(DriverException $e){
            throw new DocteurServiceException("un pb technique est arrivé");
        }
    }

    
    

}


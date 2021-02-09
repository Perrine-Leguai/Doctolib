<?php

namespace App\Service;

use App\DTO\DocteurDTO;
use App\Entity\Docteur;
use App\Mapper\DocteurMapper;
use App\Mapper\PatientMapper;
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
    private $patientMapper;
    

    public function __construct(EntityManagerInterface $manager, DocteurMapper $mapper, DocteurRepository $docteurRepository, SpecialiteRepository $specialiteRepostory, PriseRdvRepository $priseRdvRepository, PatientMapper $patientMapper){

        $this->entityManager        = $manager;
        $this->docteurMapper        = $mapper;
        $this->docteurRepository    = $docteurRepository;
        $this->specialiteRepository = $specialiteRepostory;
        $this->priseRdvRepository   = $priseRdvRepository;
        $this->patientMapper        = $patientMapper;
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

    public function searchByUsername(string $username){
        try{
            $docteur = $this->docteurRepository->findBy(["username" => $username]);
            foreach($docteur as $doc){
                $docteur = $doc;
            }
            
            return  $this->docteurMapper->transformeEntityToDocteurDto($docteur);
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

    public function searchAllPatients($id){
        try{
            $docteur = $this->docteurRepository->find($id);
            $rdvs= $docteur->getPriseRdvs();
            
            foreach($rdvs as $rdv){
               $patients[]=$this->patientMapper->transformeEntityToPatientDto($rdv->getIdPatient());
            }
    
            return $patients;
        }catch(DriverException $e){
            throw new DocteurServiceException("un pb technique est arrivé");
        }
    }
//le détail des rdvs est sur la liste rdv

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
            
            
            $specialiteDTOs=$docteurDTO->getSpecialites();
            
            if(!empty($specialiteDTOs)){
                foreach($specialiteDTOs as $specialite){
                    $specialites[]= $this->specialiteRepository->find($specialite);
                } 
             
            }
            
            $docteur= $this->docteurMapper->transformeDocteurDtoToDocteurEntity($docteurDTO, $docteur, $specialites); 
            
            $this->entityManager->flush();
        }catch(DriverException $e){
            throw new DocteurServiceException("un pb technique est arrivé");
        }
    }

    
    

}


<?php

namespace App\Controller;


use App\DTO\SpecialiteDTO;
use App\Entity\Specialite;
use App\Mapper\SpecialiteMapper;
use FOS\RestBundle\View\View;
use App\Service\SpecialiteService;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations\Get;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\Post;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\AbstractFOSRestController;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


 class SpecialiteRestController extends AbstractFOSRestController
{
    private $specialiteService;
    private $entityManager;
    private $specialiteMapper;
    private $specialiteRepo;
    

    const URI_SPECIALITE_COLLECTION = "/specialites";
    const URI_SPECIALITE_INSTANCE ="/specialites/{id}";

    public function __construct(EntityManagerInterface $entityManager, SpecialiteMapper $mapper, SpecialiteService $specialiteService){
        $this->specialiteService    = $specialiteService;
        $this->entityManager        = $entityManager;
        $this->specialiteMapper        = $mapper;
        
    }


    /**
     * @Get(SpecialiteRestController::URI_SPECIALITE_COLLECTION)
     */
    public function searchAll()
    {
        try{
            $specialites = $this->specialiteService->searchAll();
        }catch(SpecialiteServiceException $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR , ["Content-type"   =>  "application/json"]);
        }
        if($specialites){
            return View::create($specialites, Response::HTTP_OK , ["Content-type"   =>  "application/json"]);
        }else{
            return View::create($specialites, Response::HTTP_NOT_FOUND , ["Content-type"   =>  "application/json"]);
        }

    }

    /**
     * @Get(SpecialiteRestController::URI_SPECIALITE_INSTANCE)
     *
     * @return Response
     */
    public function searchById(int $id){
        try{
            $specialiteDTO = $this->specialiteService->searchById($id);
        }catch(SpecialiteServiceException $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR , ["Content-type"   =>  "application/json"]);
        }

        if($specialiteDTO !=null){
            return View :: create($specialiteDTO, Response::HTTP_OK, ["Content_type" => "application/json"]);
        }else{
            return View::create([], Response::HTTP_NOT_FOUND , ["Content-type"   =>  "application/json"]);
        }
        
    }

    /**
     * @Delete(SpecialiteRestController::URI_SPECIALITE_INSTANCE)
     *
     * @param int $id
     * @return void
     */
    public function remove(Specialite $specialite){ //pas besoin du dto car on recherche par ID de ce qui est entré dans la BDD

        try{
            
            $this->specialiteService->delete($specialite);
            return View :: create([], Response::HTTP_NO_CONTENT, ["Content_type" => "application/json"]); //no_content car on ne renvoit rien
        }catch(SpecialiteServiceException $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR , ["Content-type"   =>  "application/json"]);
           
        }
    }

    /**
     * @Post(SpecialiteRestController::URI_SPECIALITE_COLLECTION)
     * @ParamConverter("specialiteDTO", converter="fos_rest.request_body")
     *
     * @param Specialite $specialite
     * @return void
     */
    public function create(SpecialiteDTO $specialiteDTO){
        try{
            
            $this->specialiteService->persist(new Specialite(), $specialiteDTO);
            //  $categorie= $this->categorieRepository->find($specialiteDto->getCategorie());
            //  $specialite= $this->SpecialiteMapper->transformSpecialiteDtoToSpecialiteEntity($specialiteDTO, $categorie);
            // $this->entityManager->persist($specialite);
            // $this->entityManager->flush();
            
             return View :: create([], Response::HTTP_CREATED, ["Content_type" => "application/json"]);

        }catch(SpecialiteServiceException $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR , ["Content-type"   =>  "application/json"]);
        }
    }

    /**
     * @Put(SpecialiteRestController::URI_SPECIALITE_INSTANCE)
     * @ParamConverter("specialiteDTO", converter="fos_rest.request_body")
     * @param SpecialiteDTO $specialiteDTO
     * @return void
     */
    public function update(Specialite $specialite, SpecialiteDTO $specialiteDTO){
        try {
            $this->specialiteService->persist($specialite, $specialiteDTO);
            return View::create([], Response::HTTP_OK, ["Content-type" => "application/json"]);
        } catch (SpecialiteServiceException $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "application/json"]);
        }
    }
    
 }

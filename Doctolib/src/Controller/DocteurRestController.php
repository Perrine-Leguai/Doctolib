<?php

namespace App\Controller;

use App\DTO\DocteurDTO;
use App\Entity\Docteur;
use App\Mapper\DocteurMapper;
use FOS\RestBundle\View\View;
use App\Service\DocteurService;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Put;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\Post;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


class DocteurRestController extends AbstractFOSRestController
{
    private $docteurService;
    private $entityManager;
    private $docteurMapper;
    private $docteurRepo;
    private $priseRdvRepo;

    const URI_DOCTEUR_COLLECTION = "/docteurs";
    const URI_DOCTEUR_INSTANCE ="/docteurs/{id}";

    public function __construct(EntityManagerInterface $entityManager, DocteurMapper $mapper, DocteurService $docteurService){
        $this->docteurService       = $docteurService;
        $this->entityManager        = $entityManager;
        $this->DocteurMapper        = $mapper;
        
    }


    /**
     * @Get(DocteurRestController::URI_DOCTEUR_COLLECTION)
     */
    public function searchAll()
    {
        try{
            $docteurs = $this->docteurService->searchAll();
        }catch(DocteurServiceException $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR , ["Content-type"   =>  "application/json"]);
        }
        if($docteurs){
            return View::create($docteurs, Response::HTTP_OK , ["Content-type"   =>  "application/json"]);
        }else{
            return View::create($docteurs, Response::HTTP_NOT_FOUND , ["Content-type"   =>  "application/json"]);
        }

    }


    /**
     * @Get(DocteurRestController::URI_DOCTEUR_INSTANCE)
     *
     * @return Response
     */
    public function searchById(int $id){
        try{
            $docteurDTO = $this->docteurService->searchById($id);
        }catch(DocteurServiceException $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR , ["Content-type"   =>  "application/json"]);
        }

        if($docteurDTO !=null){
            return View :: create($docteurDTO, Response::HTTP_OK, ["Content_type" => "application/json"]);
        }else{
            return View::create([], Response::HTTP_NOT_FOUND , ["Content-type"   =>  "application/json"]);
        }
        
    }

    /**
     * @Delete(DocteurRestController::URI_DOCTEUR_INSTANCE)
     *
     * @param int $id
     * @return void
     */
    public function remove(Docteur $docteur){ //pas besoin du dto car on recherche par ID de ce qui est entré dans la BDD

        try{
            
            $this->docteurService->delete($docteur);
            return View :: create([], Response::HTTP_NO_CONTENT, ["Content_type" => "application/json"]); //no_content car on ne renvoit rien
        }catch(DocteurServiceException $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR , ["Content-type"   =>  "application/json"]);
           
        }
    }

    /**
     * @Post(DocteurRestController::URI_DOCTEUR_COLLECTION)
     * @ParamConverter("docteurDTO", converter="fos_rest.request_body")
     *
     * @param Docteur $docteur
     * @return void
     */
    public function create(DocteurDTO $docteurDTO){
        try{
            
            $this->docteurService->persist(new Docteur(), $docteurDTO);
            //  $categorie= $this->categorieRepository->find($docteurDto->getCategorie());
            //  $docteur= $this->DocteurMapper->transformDocteurDtoToDocteurEntity($docteurDTO, $categorie);
            // $this->entityManager->persist($docteur);
            // $this->entityManager->flush();
            
             return View :: create([], Response::HTTP_CREATED, ["Content_type" => "application/json"]);

        }catch(DocteurServiceException $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR , ["Content-type"   =>  "application/json"]);
        }
    }

    /**
     * @Put(DocteurRestController::URI_DOCTEUR_INSTANCE)
     * @ParamConverter("docteurDTO", converter="fos_rest.request_body")
     * @param DocteurDTO $docteurDTO
     * @return void
     */
    public function update(Docteur $docteur, DocteurDTO $docteurDTO){
        try {
            $this->docteurService->persist($docteur, $docteurDTO);
            return View::create([], Response::HTTP_OK, ["Content-type" => "application/json"]);
        } catch (DocteurServiceException $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "application/json"]);
        }
    }
      
}

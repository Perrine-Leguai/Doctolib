<?php

namespace App\Controller;

use App\Entity\Docteur;
use App\Entity\Patient;
use App\DTO\PriseRdvDTO;
use App\Entity\PriseRdv;
use App\DTO\PriseRdvDTODTO;
use FOS\RestBundle\View\View;
use App\Mapper\PriseRdvMapper;
use App\Service\PriseRdvService;
use App\Repository\PriseRdvRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Controller\PriseRdvRestController;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Put;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\Post;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


class PriseRdvRestController extends AbstractFOSRestController
{
    private $priseRdvService;
    private $entityManager;
    private $priseRdvMapper;
    private $priseRdvRepository;

    const URI_PRISERDV_COLLECTION = "/rdvs";
    const URI_PRISERDV_INSTANCE ="/rdvs/{id}";

    public function __construct(EntityManagerInterface $entityManager, PriseRdvMapper $mapper, PriseRdvService $priseRdvService, PriseRdvRepository $priseRdvRepository){
        $this->priseRdvService      = $priseRdvService;
        $this->entityManager        = $entityManager;
        $this->priseRdvMapper       = $mapper;
        $this->priseRdvRepository   = $priseRdvRepository;
        
    }


    /**
     * @Get(PriseRdvRestController::URI_PRISERDV_COLLECTION)
     */
    public function searchAll()
    {
        try{
            $priseRdvs = $this->priseRdvService->searchAll();
        }catch(PriseRdvServiceException $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR , ["Content-type"   =>  "application/json"]);
        }
        if($priseRdvs){
            return View::create($priseRdvs, Response::HTTP_OK , ["Content-type"   =>  "application/json"]);
        }else{
            return View::create($priseRdvs, Response::HTTP_NOT_FOUND , ["Content-type"   =>  "application/json"]);
        }

    }


    /**
     * @Get(PriseRdvRestController::URI_PRISERDV_INSTANCE)
     *
     * @return Response
     */
    public function searchById(int $id){
        try{
            $priseRdvDTO = $this->priseRdvService->searchById($id);
        }catch(PriseRdvServiceException $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR , ["Content-type"   =>  "application/json"]);
        }

        if($priseRdvDTO !=null){
            return View :: create($priseRdvDTO, Response::HTTP_OK, ["Content_type" => "application/json"]);
        }else{
            return View::create([], Response::HTTP_NOT_FOUND , ["Content-type"   =>  "application/json"]);
        }
        
     }

    /**
     * @Delete(PriseRdvRestController::URI_PRISERDV_INSTANCE)
     *
     * @param int $id
     * @return void
     */
    public function remove(PriseRdv $priseRdv){ //pas besoin du dto car on recherche par ID de ce qui est entré dans la BDD

        try{
            
            $this->priseRdvService->delete($priseRdv);
            return View :: create([], Response::HTTP_NO_CONTENT, ["Content_type" => "application/json"]); //no_content car on ne renvoit rien
        }catch(PriseRdvServiceException $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR , ["Content-type"   =>  "application/json"]);
           
        }
    }

    /**
     * @Post(PriseRdvRestController::URI_PRISERDV_COLLECTION)
     * @ParamConverter("priseRdvDTO", converter="fos_rest.request_body")
     *
     * @param PriseRdv $priseRdv
     * @return void
     */
    public function create(PriseRdvDTO $priseRdvDTO){
        try{
            $this->priseRdvService->persist(new PriseRdv(), $priseRdvDTO);
            
             return View :: create([], Response::HTTP_CREATED, ["Content_type" => "application/json"]);

        }catch(PriseRdvServiceException $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR , ["Content-type"   =>  "application/json"]);
        }
    }

    /**
     * @Put(PriseRdvRestController::URI_PRISERDV_INSTANCE)
     * @ParamConverter("priseRdvDTO", converter="fos_rest.request_body")
     * @param PriseRdvDTO $priseRdvDTO
     * @return void
     */
    public function update(PriseRdv $priseRdv, PriseRdvDTO $priseRdvDTO){
        try {
            $this->priseRdvService->persist($priseRdv, $priseRdvDTO);
            return View::create([], Response::HTTP_OK, ["Content-type" => "application/json"]);
        } catch (PriseRdvServiceException $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "application/json"]);
        }
    }
      
}

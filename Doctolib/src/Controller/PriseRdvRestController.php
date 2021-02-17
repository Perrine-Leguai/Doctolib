<?php

namespace App\Controller;

use App\Entity\Docteur;
use App\Entity\Patient;
use App\DTO\PriseRdvDTO;
use App\Entity\PriseRdv;
use App\DTO\PriseRdvDTODTO;
use FOS\RestBundle\View\View;
use OpenApi\Annotations as OA;
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

    const URI_PRISERDV_COLLECTION = "/api/rdvs";
    const URI_PRISERDV_INSTANCE ="/api/rdvs/{id}";
    const URI_PRISERDV_INSTANCE_profil ="/api/rdvs/{profil}/{id}";

    public function __construct(EntityManagerInterface $entityManager, PriseRdvMapper $mapper, PriseRdvService $priseRdvService, PriseRdvRepository $priseRdvRepository){
        $this->priseRdvService      = $priseRdvService;
        $this->entityManager        = $entityManager;
        $this->priseRdvMapper       = $mapper;
        $this->priseRdvRepository   = $priseRdvRepository;
        
    }

    /**
     * Récupérer la liste de tous les rdvs
     * @OA\Get(
     *     path="/api/rdvs",
     *     tags={"Liste des rdvs "},
     *     summary="Trouve l'ensemble des rdvs ",
     *     description="Retourne un tableau d'objets PriseRdv qui sera converti en tableau d'objets PriseRdvDTO",
     *     
     *     @OA\Response(
     *         response=200,
     *         description="Opération réussie",
     *         @OA\JsonContent(ref="#/components/schemas/PriseRdvDTO"),
     *         @OA\XmlContent(ref="#/components/schemas/PriseRdvDTO"),
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Erreur de requete"
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Nous rencontrons actuellement des problèmes"
     *      )
     * )
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
     * Récupérer la liste des rendez vous par docteurs ou par patients
     * @OA\Get(
     *     path="/api/rdvs/{profil}/{id}",
     *     tags={"Liste des rdvs selon la personne connectée"},
     *     summary="Trouve l'ensemble des rdvs d'un patient ou d'un docteur",
     *     description="Retourne un tableau d'objets PriseRdv qui sera converti en tableau d'objets PriseRdvDTO, N'est accessible qu'à la personne connectée et uniquement ses rendez vous à elle. ",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id de la personne connectée",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Opération réussie",
     *         @OA\JsonContent(ref="#/components/schemas/DocteurDTO"),
     *         @OA\XmlContent(ref="#/components/schemas/DocteurDTO"),
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Erreur de requete"
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Nous rencontrons actuellement des problèmes"
     *      )
     * )
     * @Get(PriseRdvRestController::URI_PRISERDV_INSTANCE_profil ) //id de la personne connectée dans la barre de recherche
     *
     * @return Response
     */
    public function searchById(string $profil, int $id){
        try{
            
            
            $priseRdvDTOs = $this->priseRdvService->searchById($id, $profil);
            
        }catch(PriseRdvServiceException $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR , ["Content-type"   =>  "application/json"]);
        }

        if($priseRdvDTOs !=null){
            return View :: create($priseRdvDTOs, Response::HTTP_OK, ["Content_type" => "application/json"]);
        }else{
            return View::create([], Response::HTTP_NOT_FOUND , ["Content-type"   =>  "application/json"]);
        }
        
     }

    /**
     * @OA\Delete(
     *     path="/api/rdvs/{id}",
     *     tags={"Supprimer un PriseRdv"},
     *     summary="Supprimer un rdv",
     *     description="Uniquement accessible par le docteur en question, qui est sur le rdv",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id du rdv a supprimer",
     *         required=true,
     *         @OA\Schema(
     *             type="number",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid id supplied",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Nous ne trouvons pas de rdv avec cet id",
     *     )
     * )
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
     * @OA\Post(
     *     path="/api/rdvs",
     *     tags={"Créer une PriseRdv"},
     *     summary="Création d'1 objet PriseRdv",
     *     description="Peut-^etre créé par le docteur ou le patient",
     *     
     *     @OA\Response(
     *         response=405,
     *         description="Input invalide"
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Création réussie"
     *     ),
     *     @OA\RequestBody(
     *         description="DocteurDTO JSON Object",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/PriseRdvDTO")
     *     )
     * )
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
     * @OA\Put(
     *     path="/api/rdvs/{id}",
     *     tags={"Modifier un PriseRdv"},
     *     summary="modification de objet PriseRdv selon id",
     *     description="Ne peut être réalisée que par le Docteur concerné",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id du rdv PriseRdv a modifier",
     *         required=true,
     *         @OA\Schema(
     *             type="number",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid user supplied"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Docteur non trouvé"
     *     ),
     *     @OA\RequestBody(
     *         description="Mise à jour du Docteur",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/DocteurDTO")
     *     )
     * )
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

    
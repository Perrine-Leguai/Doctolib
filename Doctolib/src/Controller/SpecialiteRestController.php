<?php

namespace App\Controller;


use App\DTO\SpecialiteDTO;
use App\Entity\Specialite;
use App\Mapper\SpecialiteMapper;
use FOS\RestBundle\View\View;
use OpenApi\Annotations as OA;
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
    

    const URI_SPECIALITE_COLLECTION = "/api/specialites";
    const URI_SPECIALITE_INSTANCE ="/api/specialites/{specialite}";
    const URI_SPECIALITE_ID = "/api/specialite/{id}";
    const URI_SPE_OPEN_COLLECTION = "/apo/specialites";

    public function __construct(EntityManagerInterface $entityManager, SpecialiteMapper $mapper, SpecialiteService $specialiteService){
        $this->specialiteService    = $specialiteService;
        $this->entityManager        = $entityManager;
        $this->specialiteMapper        = $mapper;
        
    }


    /**
     * 
     * Récupérer la liste des spécialités
     * @OA\Get(
     *  path="/apo/specialites",
     *     tags={"Toutes les specialites"},
     *     summary="Trouve l'ensemble des specialite de la bdd",
     *     description="Retourne un tableau d'objet Docteur qui sera converti en tableau d'objets DocteurDTO. Accessible par tous les utilisateurs, connectés ou non. ",
     *     
     *     @OA\Response(
     *         response=200,
     *         description="Opération réussie",
     *         @OA\JsonContent(ref="#/components/schemas/SpecialiteDTO"),
     *         @OA\XmlContent(ref="#/components/schemas/SpecialiteDTO"),
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
     * @Get(SpecialiteRestController::URI_SPE_OPEN_COLLECTION)
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
     * Récupérer la liste des Docteurs selon la spécialité
     * 
     * @OA\Get(
     *  path="/api/specialites/{id}",
     *     tags={"spécialité selon id"},
     *     summary="Trouve la spécialité selon son id",
     *     description="Accessible uniquement aux utilisateurs connectés",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="specialité selon id",
     *         required=true,
     *         @OA\Schema(type="number", format="int64")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Opération réussie",
     *         @OA\JsonContent(ref="#/components/schemas/SpecialiteDTO"),
     *         @OA\XmlContent(ref="#/components/schemas/SpecialiteDTO"),
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
     * @GET(SpecialiteRestController::URI_SPECIALITE_ID)
     *
     * @return Response
     */
    public function searchById( $id){
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
     * Récupérer la liste des Docteurs selon la spécialité
     * 
     * @OA\Get(
     *  path="/api/specialites/{specialite}",
     *     tags={"Docteurs par spécialité"},
     *     summary="Trouve l'ensemble des docteurs ayant la specialité passée en url",
     *     description="Accessible uniquement aux utilisateurs connectés",
     *     @OA\Parameter(
     *         name="nom",
     *         in="path",
     *         description="specialité à laquelle les docteurs sont rattachés",
     *         required=true,
     *         @OA\Schema(type="string")
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
     * @GET(SpecialiteRestController::URI_SPECIALITE_INSTANCE)
     *
     * @return Response
     */
    public function searchBySpecialite( $specialite){
        try{
            $docteurDTOs = $this->specialiteService->searchBySpecialite($specialite);
        }catch(SpecialiteServiceException $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR , ["Content-type"   =>  "application/json"]);
        }

        if($docteurDTOs !=null){
            return View :: create($docteurDTOs, Response::HTTP_OK, ["Content_type" => "application/json"]);
        }else{
            return View::create([], Response::HTTP_NOT_FOUND , ["Content-type"   =>  "application/json"]);
        }
        
    }

    /**
     * 
     * @OA\Post(
     *     path="/api/specialites",
     *     tags={"Créer une Specialite"},
     *     summary="Création d'1 objet Specialite",
     *     description="Ne peut être réalisée que par des adminitrateurs",
     *     @OA\Response(
     *         response=405,
     *         description="Champ mal renseigné"
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Création réussie"
     *     ),
     *     @OA\RequestBody(
     *         description="DocteurDTO JSON Object",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/SpecialiteDTO")
     *     )
     * )
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
     * @OA\Put(
     *     path="/api/specialites/{specialite}",
     *     tags={"Modifier une Specialite"},
     *     summary="modification de objet Specialite selon le nom",
     *     description="Ne peut être réalisée que par des adminitrateurs",
     *     @OA\Parameter(
     *         name="specialite",
     *         in="path",
     *         description="nom de la specialité à modifier",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid user supplied"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Specialite non trouvé"
     *     ),
     *     @OA\RequestBody(
     *         description="Mise à jour de la specialité",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/SpecialiteDTO")
     *     )
     * )
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


 
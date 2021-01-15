<?php

namespace App\Controller;

use App\DTO\DocteurDTO;
use App\Entity\Docteur;
use App\Entity\Specialite;
use App\Mapper\DocteurMapper;
use FOS\RestBundle\View\View;
use OpenApi\Annotations as OA;
use App\Service\DocteurService;
use App\Repository\SpecialiteRepository;
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

/**
 * @OA\Info(title="DocteurControlelr de l'api Rest", version="V1", description="controlelr permettant de gérer les intéraction enter le client et la base de données")
 */
class DocteurRestController extends AbstractFOSRestController
{
    private $docteurService;
    private $entityManager;
    private $docteurMapper;
    private $docteurRepo;
    private $priseRdvRepo;

    const URI_DOCTEUR_COLLECTION = "/api/docteurs";
    const URI_DOCTEUR_INSTANCE ="/api/docteurs/{id}";
    const  URI_DOCTEUR_COLLECTION_PATIENTS = "/api/docteurs/patients/{id}";

    public function __construct(EntityManagerInterface $entityManager, DocteurMapper $mapper, DocteurService $docteurService, SpecialiteRepository $specialiteRepository){
        $this->docteurService       = $docteurService;
        $this->entityManager        = $entityManager;
        $this->specialiteRepository = $specialiteRepository;
        $this->DocteurMapper        = $mapper;
        
    }


    /**
     * Récupérer la liste des Docteurs
     * @OA\Get(
     *  path="/api/docteurs",
     *     tags={"Tous les Ddocteurs"},
     *     summary="Trouve l'ensemble des docteurs grace aux fonctions du repository",
     *     description="Retourne un tableau d'objet Docteur qui sera converti en tableau d'objets DocteurDTO ",
     *     
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
     * Récupérer la liste des Partients par docteurs
     * @OA\Get(
     *     path="/api/docteurs/patients/{id}",
     *     tags={"Patients selon id du Docteur"},
     *     summary="Trouve l'ensemble des patients d'un docteur",
     *     description="Retourne un tableau d'objets Patient qui sera converti en tableau d'objets PatientDTO ",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id du Docteur dont on cherche les patients",
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
     * @Get(DocteurRestController::URI_DOCTEUR_COLLECTION_PATIENTS)
     * @return Response
     */
    public function searchAllPatients(int $id){
        try{
            // $_SESSION['role']= 'DOCTEUR';
            // if(isset($_SESSION['role'])){
                $patientDTO = $this->docteurService->searchAllPatients($id);
            //}
        }catch(DocteurServiceException $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR , ["Content-type"   =>  "application/json"]);
        }

        if($patientDTO !=null){
            return View :: create($patientDTO, Response::HTTP_OK, ["Content_type" => "application/json"]);
        }else{
            return View::create([], Response::HTTP_NOT_FOUND , ["Content-type"   =>  "application/json"]);
        }
        
    }

    /**
     * Récupérer le docteur selon son id
     * @OA\Get(
     *     path="/api/docteurs/{id}",
     *     tags={"Docteur selon id"},
     *     summary="Trouve le docteur selon son id",
     *     description="Retourne un  d'objet Docteur qui sera converti en objet DocteurDTO ",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id du Docteur que l'on cherche",
     *         required=true,
     *         @OA\Schema(
     *             type="number",
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
     * @OA\Delete(
     *     path="/api/docteurs/{id}",
     *     tags={"Supprimer un Docteur"},
     *     summary="Supprimer un docteur",
     *     description="Uniquement accessible par le docteur en question",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id du docteur à supprimer",
     *         required=true,
     *         @OA\Schema(
     *             type="number"
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid username supplied",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Nous ne trouvons pas de docteur avec cet id",
     *     )
     * )
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
     * @OA\Post(
     *     path="/api/docteurs",
     *     tags={"Créer un Docteur"},
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
     *         @OA\JsonContent(ref="#/components/schemas/DocteurDTO")
     *     )
     * )
     * @Post(DocteurRestController::URI_DOCTEUR_COLLECTION)
     * @ParamConverter("docteurDTO", converter="fos_rest.request_body")
     *
     * @param Docteur $docteur
     * @return void
     */
    public function create(DocteurDTO $docteurDTO){
        try{
            
            $this->docteurService->persist(new Docteur(), $docteurDTO);
            
            
             return View :: create([], Response::HTTP_CREATED, ["Content_type" => "application/json"]);

        }catch(DocteurServiceException $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR , ["Content-type"   =>  "application/json"]);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/docteurs/{id}",
     *     tags={"Modifier un Docteur"},
     *     summary="modification de objet Docteur selon id",
     *     description="Ne peut être réalisée que par le Docteur concerné",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id du docteur à modifier, qui est aussi l'id du docteur connecté",
     *         required=true,
     *         @OA\Schema(
     *             type="number"
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

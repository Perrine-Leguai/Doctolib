<?php

namespace App\Controller;

use App\DTO\PatientDTO;
use App\Entity\Patient;
use App\Mapper\PatientMapper;
use FOS\RestBundle\View\View;
use App\Service\PatientService;
use OpenApi\Annotations as OA;
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


class PatientRestController extends AbstractFOSRestController
{
    private $patientService;
    private $entityManager;
    private $patientMapper;
    private $patientRepo;
    private $priseRdvRepo;
    
    const URI_PATIENTS_COLLECTION ="/apo/patients/username";
    const URI_PATIENT_COLLECTION = "/api/patients";
    const URI_PATIENT_CO_INSTANCE = "/api/patients/co/{username}";
    const URI_PATIENT_INSTANCE ="/api/patients/{id}";
    
    const URI_PATIENT_COLLECTION_DOCTEURS = "/api/patients/docteurs/{id}";
    const URI_PATIENT_OPEN_COLLECTION ="/apo/patients";

    public function __construct(EntityManagerInterface $entityManager, PatientMapper $mapper, patientService $patientService){
        $this->patientService       = $patientService;
        $this->entityManager        = $entityManager;
        $this->patientMapper        = $mapper;
        
    } 
    /**
     * Récupérer la liste des Patients
     * @OA\Get(
     *  path="/apo/patients/username",
     *     tags={"Tous les patients"},
     *     summary="Trouve l'ensemble des patients grace aux fonctions du repository",
     *     description="Retourne un tableau d'objet Patients qui sera converti en tableau d'objets PatientDTO ",
     *     
     *     @OA\Response(
     *         response=200,
     *         description="Opération réussie",
     *         @OA\JsonContent(ref="#/components/schemas/PatientDTO"),
     *         @OA\XmlContent(ref="#/components/schemas/PatientDTO"),
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
     * @Get(PatientRestController::URI_PATIENTS_COLLECTION)
     */
    public function searchAll()
    {
        try{
            $patients = $this->patientService->searchAllByName();
        }catch(PatientServiceException $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR , ["Content-type"   =>  "application/json"]);
        }
        if($patients){
            return View::create($patients, Response::HTTP_OK , ["Content-type"   =>  "application/json"]);
        }else{
            return View::create($patients, Response::HTTP_NOT_FOUND , ["Content-type"   =>  "application/json"]);
        }

    }

    /**
     * Récupérer le patient selon son id
     * @OA\Get(
     *     path="/api/patients/{id}",
     *     tags={"Patients selon id"},
     *     summary="Trouve le patient selon son id",
     *     description="Retourne un  d'objet Patient qui sera converti en objet PatientDTO ",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id du Patient que l'on cherche",
     *         required=true,
     *         @OA\Schema(
     *             type="number",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Opération réussie",
     *         @OA\JsonContent(ref="#/components/schemas/PatientDTO"),
     *         @OA\XmlContent(ref="#/components/schemas/PatientDTO"),
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
     * @Get(PatientRestController::URI_PATIENT_INSTANCE)
     *
     * @return Response
     */
    public function searchById(int $id){
        try{
            $patientDTO = $this->patientService->searchById($id);
        }catch(PatientServiceException $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR , ["Content-type"   =>  "application/json"]);
        }

        if($patientDTO !=null){
            return View :: create($patientDTO, Response::HTTP_OK, ["Content_type" => "application/json"]);
        }else{
            return View::create([], Response::HTTP_NOT_FOUND , ["Content-type"   =>  "application/json"]);
        }
        
    }

    /**
     * Récupérer le patient selon son username
     * @OA\Get(
     *     path="/api/patients/co/{username}",
     *     tags={"Patients selon username"},
     *     summary="Trouve le patient selon son username",
     *     description="Retourne un  d'objet Patient qui sera converti en objet PatientDTO ",
     *     @OA\Parameter(
     *         name="username",
     *         in="path",
     *         description="username du Patient que l'on cherche",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Opération réussie",
     *         @OA\JsonContent(ref="#/components/schemas/PatientDTO"),
     *         @OA\XmlContent(ref="#/components/schemas/PatientDTO"),
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
     * @Get(PatientRestController::URI_PATIENT_CO_INSTANCE)
     *
     * @return Response
     */
    public function searchOneByUsername(string $username){
        try{
            $patientDTO = $this->patientService->searchByUsername($username);
        }catch(PatientServiceException $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR , ["Content-type"   =>  "application/json"]);
        }

        if($patientDTO !=null){
            return View :: create($patientDTO, Response::HTTP_OK, ["Content_type" => "application/json"]);
        }else{
            return View::create([], Response::HTTP_NOT_FOUND , ["Content-type"   =>  "application/json"]);
        }
        
    }

    /**
     *  Récupérer la liste des docteurs d'un patient précisé par l'id
     * @OA\Get(
     *  path="/api/patients/docteurs/{id}",
     *     tags={"Patients selon id Docteur"},
     *     summary="Trouve l'ensemble des patients inscrits sur la bdd, ayant au moins un rendez vous avec le Docteur précisé par l'id dans l'URL",
     *     description="Retourne un tableau d'objets Patient qui sera converti en tableau d'objets PatientDTO ",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id du Docteur dont on cherche la liste des patients",
     *         required=true,
     *         @OA\Schema(
     *             type="number",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Opération réussie",
     *         @OA\JsonContent(ref="#/components/schemas/PatientDTO"),
     *         @OA\XmlContent(ref="#/components/schemas/PatientDTO"),
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Aucun docteur ne coreespond à votre requête"
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Nous rencontrons actuellement des problèmes"
     *      )
     * )
     * @Get(PatientRestController::URI_PATIENT_COLLECTION_DOCTEURS)
     * @return Response
     */
    public function searchAllDocteurs(int $id){
        try{
            // $_SESSION['role']= 'DOCTEUR';
            // if(isset($_SESSION['role'])){
                $docteurDTO = $this->patientService->searchAllDocteurs($id);
            //}
        }catch(PatientServiceException $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR , ["Content-type"   =>  "application/json"]);
        }

        if($docteurDTO !=null){
            return View :: create($docteurDTO, Response::HTTP_OK, ["Content_type" => "application/json"]);
        }else{
            return View::create([], Response::HTTP_NOT_FOUND , ["Content-type"   =>  "application/json"]);
        }
        
    }

// SUPPRESSION DU COMPTE, NE PEUT ÊTRE FAIT QUE PAR LE PATIENT LUI MM
    /**
     *  @OA\Delete(
     *     path="/api/patients/{id}",
     *     tags={"Supprimer un Patient"},
     *     summary="Supprimer un patient",
     *     description="Uniquement accessible par le patient en question. L'ID se récupère automatiquement à la connexion du patient dans un $_SESSION",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id du patient à supprimer",
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
     *         description="Nous ne trouvons pas de patient avec cet id"
     *     )
     * )
     * 
     * @Delete(PatientRestController::URI_PATIENT_INSTANCE)
     *
     * @param int $id
     * @return void
     */
    public function remove(Patient $patient){ //pas besoin du dto car on recherche par ID de ce qui est entré dans la BDD

        try{
            
            $this->patientService->delete($patient);
            return View :: create([], Response::HTTP_NO_CONTENT, ["Content_type" => "application/json"]); //no_content car on ne renvoit rien
        }catch(PatientServiceException $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR , ["Content-type"   =>  "application/json"]);
           
        }
    }

//INSCRIPTION SUR LE SITE
    /**
     * @OA\Post(
     *     path="/apo/patients",
     *     tags={"Créer un Patient"},
     *     summary="Création d'1 patient",
     *     description="Créationd u patient en inscription sur le site",
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
     *         description="PatientDTO JSON Object",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/PatientDTO")
     *     )
     * )
     * @Post(PatientRestController::URI_PATIENT_OPEN_COLLECTION)
     * @ParamConverter("patientDTO", converter="fos_rest.request_body")
     *
     * @param Patient $patient
     * @return void
     */
    public function create(PatientDTO $patientDTO){
        try{
            
            $this->patientService->persist(new Patient(), $patientDTO);
            
             return View :: create([], Response::HTTP_CREATED, ["Content_type" => "application/json"]);

        }catch(PatientServiceException $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR , ["Content-type"   =>  "application/json"]);
        }
    }

//MODIFICATION DU COMPTE, NE PEUT ÊTRE FAITE QUE PAR LE PATIENT LUI MM
    /**
      * @OA\Put(
     *     path="/api/patients/{id}",
     *     tags={"Modifier un Patient"},
     *     summary="modification de objet Patient selon id",
     *     description="Ne peut être réalisée que par le Patient concerné",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id du patient à modifier, qui est aussi l'id du patient connecté",
     *         required=true,
     *         @OA\Schema(
     *             type="number",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid id supplied"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Patient non trouvé"
     *     ),
     *     @OA\RequestBody(
     *         description="Mise à jour du Patient",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/PatientDTO")
     *     )
     * )
     * @Put(PatientRestController::URI_PATIENT_INSTANCE)
     * @ParamConverter("patientDTO", converter="fos_rest.request_body")
     * @param PatientDTO $patientDTO
     * @return void
     */
    public function update(Patient $patient, PatientDTO $patientDTO){
        try {
            $this->patientService->persist($patient, $patientDTO);
            return View::create([], Response::HTTP_OK, ["Content-type" => "application/json"]);
        } catch (PatientServiceException $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "application/json"]);
        }
    }
      
}


    // /**
    //  * @Get(PatientRestController::URI_PATIENT_COLLECTION)
    //  */
    // public function searchAll()
    // {
    //     try{
    //         $patients = $this->patientService->searchAll();
    //     }catch(PatientServiceException $e){
    //         return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR , ["Content-type"   =>  "application/json"]);
    //     }
    //     if($patients){
    //         return View::create($patients, Response::HTTP_OK , ["Content-type"   =>  "application/json"]);
    //     }else{
    //         return View::create($patients, Response::HTTP_NOT_FOUND , ["Content-type"   =>  "application/json"]);
    //     }

    // }
<?php

namespace App\Controller;

use App\DTO\PatientDTO;
use App\Entity\Patient;
use App\Mapper\PatientMapper;
use FOS\RestBundle\View\View;
use App\Service\PatientService;
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

    const URI_PATIENT_COLLECTION = "/patients";
    const URI_PATIENT_INSTANCE ="/patients/{id}";

    public function __construct(EntityManagerInterface $entityManager, PatientMapper $mapper, patientService $patientService){
        $this->patientService       = $patientService;
        $this->entityManager        = $entityManager;
        $this->patientMapper        = $mapper;
        
    }


    /**
     * @Get(PatientRestController::URI_PATIENT_COLLECTION)
     */
    public function searchAll()
    {
        try{
            $patients = $this->patientService->searchAll();
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

    /**
     * @Post(PatientRestController::URI_PATIENT_COLLECTION)
     * @ParamConverter("patientDto", converter="fos_rest.request_body")
     *
     * @param Patient $patient
     * @return void
     */
    public function create(PatientDTO $patientDTO){
        try{
            $patient= new PatientService();
            $patient->persist(new Patient(), $patientDTO);
            //  $categorie= $this->categorieRepository->find($patientDto->getCategorie());
            //  $patient= $this->PatientMapper->transformPatientDtoToPatientEntity($patientDTO, $categorie);
            // $this->entityManager->persist($patient);
            // $this->entityManager->flush();
            
             return View :: create([], Response::HTTP_CREATED, ["Content_type" => "application/json"]);

        }catch(PatientServiceException $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR , ["Content-type"   =>  "application/json"]);
        }
    }

    /**
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

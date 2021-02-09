<?php

namespace App\DTO;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     title="PriseRdvDTO",
 *     @OA\Xml(
 *         name="PriseRdvDTO"
 *     )
 * ) */
class PriseRdvDTO{
    
    /**
     * @OA\Property(
     *     title="ID",
     *     description="ID",
     *     type="number",
     *     format="int64",
     * )
     *
     * @var integer
     */ 
    private $id;
    /**
     * @OA\Property(
     *     title="date",
     *     description="date du rendez vous médical",
     *     type="string",
     *     format="date-time"
     * )
     *
     * @var integer
     */ 
    private $date;
    
    /**
     * @OA\Property(
     *     title="docteur concerné par le rdv",
     *     description="id du docteur concerné par le rdv",
     *     type= "number",
     *     format="int32",       
     * )
     * @var int
     */
    private $id_docteur;
    /**
     * @OA\Property(
     *     title="patient concerné par le rdv",
     *     description="id du patient concerné par le rdv",
     *     type= "number",
     *     format="int32",      
     * )
     * @var int
     */
    private $idPatient;

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of date
     */ 
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set the value of date
     *
     * @return  self
     */ 
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get the value of id_docteur
     */ 
    public function getIdDocteur()
    {
        return $this->id_docteur;
    }

    /**
     * Set the value of id_docteur
     *
     * @return  self
     */ 
    public function setIdDocteur($id_docteur)
    {
        $this->id_docteur = $id_docteur;

        return $this;
    }

    /**
     * Get the value of idPatient
     */ 
    public function getIdPatient()
    {
        return $this->idPatient;
    }

    /**
     * Set the value of idPatient
     *
     * @return  self
     */ 
    public function setIdPatient($idPatient)
    {
        $this->idPatient = $idPatient;

        return $this;
    }
}
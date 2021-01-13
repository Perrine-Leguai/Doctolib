<?php

namespace App\DTO;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema()
 */
class SpecialiteDTO{
    /**
     * @OA\Property(type="integer", format="int64")
     *
     * @var int
     */
    private $id;
    /**
     * @OA\Property(
     *     title="nom",
     *     description="libelle de la specialite, , obligatoire",
     *     type="string",
     * )
     *
     * @var string
     */ 
    private $nom;
    
    /**
     * @OA\Property(
     *     title="docteurs",
     *     description="tableaux des docteurs ayant cette spécialité",
     *     type= "array",
     *     items = {"type"="object"}
     * )
     *
     * @var array
     */ 
    private $docteurs;

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
     * Get the value of nom
     */ 
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set the value of nom
     *
     * @return  self
     */ 
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get the value of docteurs
     */ 
    public function getDocteurs()
    {
        return $this->docteurs;
    }

    /**
     * Set the value of docteurs
     *
     * @return  self
     */ 
    public function setDocteurs($docteurs)
    {
        $this->docteurs = $docteurs;

        return $this;
    }
}
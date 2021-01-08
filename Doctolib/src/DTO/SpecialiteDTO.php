<?php

namespace App\DTO;

class SpecialiteDTO{

    private $id;
    private $nom;
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
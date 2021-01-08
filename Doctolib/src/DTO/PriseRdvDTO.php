<?php

namespace App\DTO;

class PriseRdvDTO{

    private $id;
    private $date;
    private $id_docteur;
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
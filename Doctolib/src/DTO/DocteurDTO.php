<?php

namespace App\DTO;

class DocteurDTO{
    
     
    private $id;
    private $username;
    private $password;

    private $numeroOrdre;
    private $nom;
    private $prenom;
    private $adresseTravail;
    private $codePostal;
    private $ville;
    private $email;
    private $telephone;
    private $lienSiteInternet;
    
    private $specialites;
    private $priseRdvs;



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
     * Get the value of numeroOrdre
     */ 
    public function getNumeroOrdre()
    {
        return $this->numeroOrdre;
    }

    /**
     * Set the value of numeroOrdre
     *
     * @return  self
     */ 
    public function setNumeroOrdre($numeroOrdre)
    {
        $this->numeroOrdre = $numeroOrdre;

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
     * Get the value of prenom
     */ 
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set the value of prenom
     *
     * @return  self
     */ 
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get the value of adresseTravail
     */ 
    public function getAdresseTravail()
    {
        return $this->adresseTravail;
    }

    /**
     * Set the value of adresseTravail
     *
     * @return  self
     */ 
    public function setAdresseTravail($adresseTravail)
    {
        $this->adresseTravail = $adresseTravail;

        return $this;
    }

    
    /**
     * Get the value of codePostal
     */ 
    public function getCodePostal()
    {
        return $this->codePostal;
    }

    /**
     * Set the value of codePostal
     *
     * @return  self
     */ 
    public function setCodePostal($codePostal)
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    /**
     * Get the value of ville
     */ 
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Set the value of ville
     *
     * @return  self
     */ 
    public function setVille($ville)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    

    /**
     * Get the value of telephone
     */ 
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Set the value of telephone
     *
     * @return  self
     */ 
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Get the value of lienSiteInternet
     */ 
    public function getLienSiteInternet()
    {
        return $this->lienSiteInternet;
    }

    /**
     * Set the value of lienSiteInternet
     *
     * @return  self
     */ 
    public function setLienSiteInternet($lienSiteInternet)
    {
        $this->lienSiteInternet = $lienSiteInternet;

        return $this;
    }

    /**
     * Get the value of specialites
     */ 
    public function getSpecialites()
    {
        return $this->specialites;
    }

    /**
     * Set the value of specialites
     *
     * @return  self
     */ 
    public function setSpecialites($specialites)
    {
        $this->specialites = $specialites;

        return $this;
    }

    /**
     * Get the value of priseRdvs
     */ 
    public function getPriseRdvs()
    {
        return $this->priseRdvs;
    }

    /**
     * Set the value of priseRdvs
     *
     * @return  self
     */ 
    public function setPriseRdvs($priseRdvs)
    {
        $this->priseRdvs = $priseRdvs;

        return $this;
    }

    /**
     * Get the value of username
     */ 
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set the value of username
     *
     * @return  self
     */ 
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get the value of password
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */ 
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }
}
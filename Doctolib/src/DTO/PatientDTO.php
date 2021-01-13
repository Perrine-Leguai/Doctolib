<?php

namespace App\DTO;
use OpenApi\Annotations as OA;


/**
 * @OA\Schema(
 *     title="PatientDTO",
 *     @OA\Xml(
 *         name="PatientDTO"
 *     )
 * ) */
class PatientDTO{
    
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
     *     title="username",
     *     description="username, unique, obligatoire",
     *     type="string",
     * )
     *
     * @var string
     */ 
    private $username;
    /**
     * @OA\Property(
     *     title="password",
     *     description="password, hashé,obligatoire",
     *     type="string",
     * )
     *
     * @var string
     */ 
    private $password;

    /**
     * @OA\Property(
     *     title="numero carte vitale",
     *     description="numero de la carte vitale, unique également, obligatoire",
     *     type="string",
     *     format="password"
     * )
     *
     * @var string
     */ 
    private $numeroCarteVitale;
    /**
     * @OA\Property(
     *     title="nom",
     *     description="nom obligatoire",
     *     type="string",
     * )
     *
     * @var string
     */ 
    private $nom;
    /**
     * @OA\Property(
     *     title="prénom",
     *     description="prénom obligatoire",
     *     type="string",
     * )
     *
     * @var string
     */ 
    private $prenom;
    /**
     * @OA\Property(
     *     title="adresse",
     *     description="adresse obligatoire",
     *     type="string",
     * )
     *
     * @var string
     */ 
    private $adresse;
    /**
     * @OA\Property(
     *     title="ville",
     *     description="ville obligatoire",
     *     type="string",
     * )
     *
     * @var string
     */ 
    private $ville;
    /**
     * @OA\Property(
     *     title="code postal",
     *     description="code postal obligatoire",
     *     type="string",
     * )
     *
     * @var string
     */ 
    private $codePostal;
    /**
     * @OA\Property(
     *     title="email",
     *     description="email obligatoire",
     *     type="string",
     * )
     *
     * @var string
     */ 
    private $email;
    /**
     * @OA\Property(
     *     title="telephone",
     *     description="telephone pas obligatoire",
     *     type="string",
     * )
     *
     * @var string
     */ 
    private $telephone;

    /**
     * @OA\Property(
     *     title="rendez-vous",
     *     description="tableaux des rendez vous du patient, les rendez vosu sont aussi des objets.",
     *     type= "array",
     *     items = {"type"="object"}       
     * )
     * @var array
     */ 
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
     * Get the value of adresse
     */ 
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set the value of adresse
     *
     * @return  self
     */ 
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

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
    public function setPriseRdvs($priseRdvs=null)
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

    /**
     * Get the value of numeroCarteVitale
     */ 
    public function getNumeroCarteVitale()
    {
        return $this->numeroCarteVitale;
    }

    /**
     * Set the value of numeroCarteVitale
     *
     * @return  self
     */ 
    public function setNumeroCarteVitale($numeroCarteVitale)
    {
        $this->numeroCarteVitale = $numeroCarteVitale;

        return $this;
    }
}
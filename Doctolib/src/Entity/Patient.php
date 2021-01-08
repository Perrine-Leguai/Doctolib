<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\PatientRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=PatientRepository::class)
 */
class Patient extends User
{
    

    /**
     * @ORM\Column(type="string", length=15)
     * @Assert\NotBlank(message="Le numéro de Carte Vital est obligatoire.")
     * @Assert\Regex(pattern="@^[12][0-9]{2}(0[1-9]|1[0-2])(2[AB]|[0-9]{2})[0-9]{3}[0-9]{3}([0-9]{2})?$@", message="Veuillez saisir un numéro entre 13 et 15 chiffres, 2A et 2B acceptés")
     */
    private $numeroCarteVitale;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Champ obligatoire")
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Champ obligatoire")
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Champ obligatoire")
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Champ obligatoire")
     */
    private $ville;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="Champ obligatoire")
     * @Assert\Regex(pattern="/^[0-9]{4,6}$/", message="Veuillez saisir un code postal correct")
     */
    private $codePostal;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     * @Assert\Regex(pattern="/^[0-9]{10}|d{13}$/", message="N'entrez que des chiffres. Si vous utilisez un +33 (par exemple), remplacer par 0033")
     */
    private $telephone;

    /**
     * @ORM\OneToMany(targetEntity=PriseRdv::class, mappedBy="idPatient", cascade={"persist", "remove"})
     */
    private $priseRdvs;


    public function __construct()
    {
        $this->rendezVous = new ArrayCollection();
        $this->priseRdvs = new ArrayCollection();
    }

    

    public function getNumeroCarteVitale(): ?string
    {
        return $this->numeroCarteVitale;
    }

    public function setNumeroCarteVitale(?string $numeroCarteVitale): self
    {
        $this->numeroCarteVitale = $numeroCarteVitale;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(?string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->codePostal;
    }

    public function setCodePostal(?string  $codePostal): self
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * @return Collection|PriseRdv[]
     */
    public function getPriseRdvs(): Collection
    {
        return $this->priseRdvs;
    }

    public function addPriseRdv(PriseRdv $priseRdv): self
    {
        if (!$this->priseRdvs->contains($priseRdv)) {
            $this->priseRdvs[] = $priseRdv;
            $priseRdv->setIdPatient($this);
        }

        return $this;
    }

    public function removePriseRdv(PriseRdv $priseRdv): self
    {
        if ($this->priseRdvs->removeElement($priseRdv)) {
            // set the owning side to null (unless already changed)
            if ($priseRdv->getIdPatient() === $this) {
                $priseRdv->setIdPatient(null);
            }
        }

        return $this;
    }

    
}

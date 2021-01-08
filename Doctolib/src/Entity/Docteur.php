<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\DocteurRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass=DocteurRepository::class)
 */
class Docteur extends User

{
    

    /**
     * @ORM\Column(type="string", length=9)
     * @Assert\NotBlank(message="numero d'ordre des médecins obligatoire")
     * @Assert\Regex(pattern="/^[0-9]{9}$/", message="Le numéro d'ordre est constitué de 9 chiffres")
     */
    private $numeroOrdre;

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
    private $adresseTravail;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="Champ obligatoire")
     * @Assert\Regex(pattern="/^[0-9]{5,6}$/", message="Veuillez saisir un code postal correct")
     */
    private $codePostal;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Champ obligatoire")
     */
    private $ville;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Champ obligatoire")
     * @Assert\Email(message="Adresse email erronée")
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     * @Assert\Regex(pattern="/^[0-9]{10}|d{13}$/", message="N'entrez que des chiffres. Si vous utilisez un +33 (par exemple), remplacer par 0033")
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lienSiteInternet;

    /**
     * @ORM\ManyToMany(targetEntity=Specialite::class, mappedBy="docteurs")
     */
    private $specialites;

    /**
     * @ORM\OneToMany(targetEntity=PriseRdv::class, mappedBy="id_docteur",  cascade={"persist", "remove"})
     */
    private $priseRdvs;

    public function __construct()
    {
        $this->specialites = new ArrayCollection();
        $this->priseRdvs = new ArrayCollection();
    }

    

    public function getNumeroOrdre(): ?string
    {
        return $this->numeroOrdre;
    }

    public function setNumeroOrdre(?string $numeroOrdre): self
    {
        $this->numeroOrdre = $numeroOrdre;

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

    public function getAdresseTravail(): ?string
    {
        return $this->adresseTravail;
    }

    public function setAdresseTravail(?string $adresseTravail): self
    {
        $this->adresseTravail = $adresseTravail;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->codePostal;
    }

    public function setCodePostal(?string $codePostal): self
    {
        $this->codePostal = $codePostal;

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

    public function getLienSiteInternet(): ?string
    {
        return $this->lienSiteInternet;
    }

    public function setLienSiteInternet(?string $lienSiteInternet): self
    {
        $this->lienSiteInternet = $lienSiteInternet;

        return $this;
    }

    /**
     * @return Collection|Specialite[]
     */
    public function getSpecialites(): Collection
    {
        return $this->specialites;
    }

    public function addSpecialite(Specialite $specialite): self
    {
        if (!$this->specialites->contains($specialite)) {
            $this->specialites[] = $specialite;
            $specialite->addDocteur($this);
        }

        return $this;
    }

    public function removeSpecialite(Specialite $specialite): self
    {
        if ($this->specialites->removeElement($specialite)) {
            $specialite->removeDocteur($this);
        }

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
            $priseRdv->setIdDocteur($this);
        }

        return $this;
    }

    public function removePriseRdv(PriseRdv $priseRdv): self
    {
        if ($this->priseRdvs->removeElement($priseRdv)) {
            // set the owning side to null (unless already changed)
            if ($priseRdv->getIdDocteur() === $this) {
                $priseRdv->setIdDocteur(null);
            }
        }

        return $this;
    }

    
}

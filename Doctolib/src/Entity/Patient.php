<?php

namespace App\Entity;

use App\Repository\PatientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PatientRepository::class)
 */
class Patient
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="Champ obligatoire")
     * @Assert\Regex(pattern="'/^[12][0-9]{2}(0[1-9]|1[0-2])(2[AB]|[0-9]{2})[0-9]{3}[0-9]{3}([0-9]{2})?$/x'", message="Veuillez saisir un numéro entre 13 et 15 chiffres, 2A et 2B acceptés")
     * 
     */
    private $numeroCarteVitale;

    /**
     * @ORM\Column(type="string", length=255)
     * @Asset\NotBlank(message="Champ obligatoire")
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Asset\NotBlank(message="Champ obligatoire")
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Asset\NotBlank(message="Champ obligatoire")
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=255)
     * @Asset\NotBlank(message="Champ obligatoire")
     */
    private $ville;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Regex(pattern="\d{5,6}", message="Veuillez saisir un code postal correct")
     */
    private $codePostal;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     * @Assert\Regex(pattern="\d{10}|d{13}", message="N'entrez que des chiffres. Si vous utilisez un +33 (par exemple), remplacer par 0033")
     */
    private $telephone;

    /**
     * @ORM\ManyToMany(targetEntity=docteur::class, inversedBy="rdvPatient")
     */
    private $rendezVous;


    public function __construct()
    {
        $this->rendezVous = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumeroCarteVitale(): ?int
    {
        return $this->numeroCarteVitale;
    }

    public function setNumeroCarteVitale(int $numeroCarteVitale): self
    {
        $this->numeroCarteVitale = $numeroCarteVitale;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getCodePostal(): ?int
    {
        return $this->codePostal;
    }

    public function setCodePostal(int $codePostal): self
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
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
     * @return Collection|docteur[]
     */
    public function getRendezVous(): Collection
    {
        return $this->rendezVous;
    }

    public function addRendezVou(docteur $rendezVou): self
    {
        if (!$this->rendezVous->contains($rendezVou)) {
            $this->rendezVous[] = $rendezVou;
        }

        return $this;
    }

    public function removeRendezVou(docteur $rendezVou): self
    {
        $this->rendezVous->removeElement($rendezVou);

        return $this;
    }

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function setDate(string $date): self
    {
        $this->date = $date;

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\SpecialiteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=SpecialiteRepository::class)
 */
class Specialite
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le libellé est obligatoire.")
     */
    private $nom;

    /**
     * @ORM\ManyToMany(targetEntity=Docteur::class, inversedBy="specialites")
     */
    private $libelle;

    public function __construct()
    {
        $this->libelle = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection|docteur[]
     */
    public function getLibelle(): Collection
    {
        return $this->libelle;
    }

    public function addLibelle(docteur $libelle): self
    {
        if (!$this->libelle->contains($libelle)) {
            $this->libelle[] = $libelle;
        }

        return $this;
    }

    public function removeLibelle(docteur $libelle): self
    {
        $this->libelle->removeElement($libelle);

        return $this;
    }
}

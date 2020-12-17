<?php

namespace App\Entity;

use App\Repository\PriseRdvRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Type;


/**
 * @ORM\Entity(repositoryClass=PriseRdvRepository::class)
 */
class PriseRdv
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank(message="La date de rdv est obligatoire.")
     * @Assert\DateTime
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity=Docteur::class, inversedBy="priseRdvs")
     */
    private $id_docteur;

    /**
     * @ORM\ManyToOne(targetEntity=Patient::class, inversedBy="priseRdvs")
     */
    private $idPatient;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getIdDocteur(): ?docteur
    {
        return $this->id_docteur;
    }

    public function setIdDocteur(?docteur $id_docteur): self
    {
        $this->id_docteur = $id_docteur;

        return $this;
    }

    public function getIdPatient(): ?patient
    {
        return $this->idPatient;
    }

    public function setIdPatient(?patient $idPatient): self
    {
        $this->idPatient = $idPatient;

        return $this;
    }
}

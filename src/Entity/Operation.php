<?php

namespace App\Entity;

use App\Repository\OperationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OperationRepository::class)]
class Operation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_operation = null;

    #[ORM\Column(length: 255)]
    private ?string $type_operation = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_medecin = null;

    #[ORM\Column]
    private ?int $cout_operation = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $note_operation = null;

    #[ORM\ManyToOne(inversedBy: 'Operation')]
    private ?Maladie $maladie = null;

    #[ORM\ManyToOne(inversedBy: 'operations')]
    private ?Animal $animal = null;

   

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateOperation(): ?\DateTimeInterface
    {
        return $this->date_operation;
    }

    public function setDateOperation(\DateTimeInterface $date_operation): self
    {
        $this->date_operation = $date_operation;

        return $this;
    }

    public function getTypeOperation(): ?string
    {
        return $this->type_operation;
    }

    public function setTypeOperation(string $type_operation): self
    {
        $this->type_operation = $type_operation;

        return $this;
    }

    public function getNomMedecin(): ?string
    {
        return $this->nom_medecin;
    }

    public function setNomMedecin(string $nom_medecin): self
    {
        $this->nom_medecin = $nom_medecin;

        return $this;
    }

    public function getCoutOperation(): ?int
    {
        return $this->cout_operation;
    }

    public function setCoutOperation(int $cout_operation): self
    {
        $this->cout_operation = $cout_operation;

        return $this;
    }

    public function getNoteOperation(): ?string
    {
        return $this->note_operation;
    }

    public function setNoteOperation(string $note_operation): self
    {
        $this->note_operation = $note_operation;

        return $this;
    }

    public function getMaladie(): ?Maladie
    {
        return $this->maladie;
    }

    public function setMaladie(?Maladie $maladie): self
    {
        $this->maladie = $maladie;

        return $this;
    }

    public function getAnimal(): ?Animal
    {
        return $this->animal;
    }

    public function setAnimal(?Animal $animal): self
    {
        $this->animal = $animal;

        return $this;
    }
}

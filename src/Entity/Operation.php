<?php

namespace App\Entity;

use App\Repository\OperationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: OperationRepository::class)]
class Operation
{

  

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
     

    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
     /**
     * @Assert\NotBlank
     * @Assert\DateTime
     * @Assert\GreaterThanOrEqual(
     *     "today",
     *     message="La date de l'opération ne peut pas être antérieure à aujourd'hui"
     * )
     * @Assert\LessThanOrEqual(
     *     "+1 year",
     *     message="La date de l'opération ne peut pas être postérieure à un an à partir d'aujourd'hui"
     * )
     */
    private ?\DateTimeInterface $date_operation = null;

    #[ORM\Column(length: 255)]
    /**
     * @Assert\NotBlank
     * @Assert\Choice(choices={"consultation", "vaccination", "surgury"})
     */
    private ?string $type_operation = null;

    #[ORM\Column(length: 255)]
    /**
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Le nom du médecin doit contenir au moins {{ limit }} caractères",
     *      maxMessage = "Le nom du médecin doit contenir moins de {{ limit }} caractères"
     * )
     */
    private ?string $nom_medecin = null;

    #[ORM\Column]
        /**
     * @Assert\NotBlank
     * @Assert\Type(
     *     type="numeric",
     *     message="Le coût de l'opération doit être un nombre"
     * )
     * @Assert\Positive(
     *     message="Le coût de l'opération doit être un nombre positif"
     * )
     */
    private ?int $cout_operation = null;

    #[ORM\Column(type: Types::TEXT)]
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 7,
     *      max = 100,
     *      minMessage = "La note doit contenir au moins {{ limit }} caractères",
     *      maxMessage = "La note doit contenir moins de {{ limit }} caractères"
     * )
     */
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

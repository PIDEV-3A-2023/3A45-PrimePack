<?php

namespace App\Entity;

use App\Repository\MaladieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: MaladieRepository::class)]
class Maladie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    
  
    private ?int $id = null;
    
    
    
   
   
    
    #[ORM\Column(type:"string", length:255)]
     #[Assert\Length(
          min : 3,
          max : 50,
          minMessage: "Le nom  est trop court",
          maxMessage:"Le nom est trop long")]
      
     
    private ?string $nom = null;
     

    #[ORM\Column(type: Types::TEXT)]
     

    #[Assert\NotBlank]
    #[Assert\Length(
          min : 7,
          max : 100,
          minMessage : "La description doit contenir au moins {{ limit }} caractères",
          maxMessage : "La description doit contenir moins de {{ limit }} caractères"
     )]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    
     #[Assert\NotBlank(message:"Chat/Chien/Oiseau/Autre")]
     #[Assert\Choice(['Chien', 'Chat', 'Oiseau', 'Autre'])]
     
    private ?string $type_aniaml = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
  
    private ?\DateTimeInterface $date_creation = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    
    private ?\DateTimeInterface $date_MAJ = null;

    #[ORM\OneToMany(mappedBy: 'maladie', targetEntity: Operation::class)]
    private Collection $Operation;

    #[ORM\OneToMany(mappedBy: 'maladie', targetEntity: Animal::class)]
    private Collection $animals;

    #[ORM\ManyToOne(inversedBy: 'maladies')]
    private ?Animal $animal = null;

    public function __toString()
    {
        return $this->nom;
    }


    public function __construct()
    {
        $this->Operation = new ArrayCollection();
        $this->animals = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getTypeAniaml(): ?string
    {
        return $this->type_aniaml;
    }

    public function setTypeAniaml(string $type_aniaml): self
    {
        $this->type_aniaml = $type_aniaml;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->date_creation;
    }

    public function setDateCreation(\DateTimeInterface $date_creation): self
    {
        $this->date_creation = $date_creation;

        return $this;
    }

    public function getDateMAJ(): ?\DateTimeInterface
    {
        return $this->date_MAJ;
    }

    public function setDateMAJ(\DateTimeInterface $date_MAJ): self
    {
        $this->date_MAJ = $date_MAJ;

        return $this;
    }

    /**
     * @return Collection<int, Operation>
     */
    public function getOperation(): Collection
    {
        return $this->Operation;
    }

    public function addOperation(Operation $operation): self
    {
        if (!$this->Operation->contains($operation)) {
            $this->Operation->add($operation);
            $operation->setMaladie($this);
        }

        return $this;
    }

    public function removeOperation(Operation $operation): self
    {
        if ($this->Operation->removeElement($operation)) {
            // set the owning side to null (unless already changed)
            if ($operation->getMaladie() === $this) {
                $operation->setMaladie(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Animal>
     */
    public function getAnimals(): Collection
    {
        return $this->animals;
    }

    public function addAnimal(Animal $animal): self
    {
        if (!$this->animals->contains($animal)) {
            $this->animals->add($animal);
            $animal->setMaladie($this);
        }

        return $this;
    }

    public function removeAnimal(Animal $animal): self
    {
        if ($this->animals->removeElement($animal)) {
            // set the owning side to null (unless already changed)
            if ($animal->getMaladie() === $this) {
                $animal->setMaladie(null);
            }
        }

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

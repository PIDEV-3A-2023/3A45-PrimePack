<?php

namespace App\Entity;

use App\Repository\AnimalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnimalRepository::class)]
class Animal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $race = null;

    #[ORM\Column(length: 255)]
    private ?string $genre = null;

    #[ORM\Column(length: 255)]
    private ?string $age = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'animal', targetEntity: RendezVous::class)]
    private Collection $rendezVouses;

    #[ORM\OneToMany(mappedBy: 'animal', targetEntity: Operation::class)]
    private Collection $operations;

    #[ORM\ManyToOne(inversedBy: 'animals')]
    private ?Maladie $maladie = null;

    #[ORM\OneToMany(mappedBy: 'animal', targetEntity: Maladie::class)]
    private Collection $maladies;

    #[ORM\ManyToOne(inversedBy: 'animal')]
    private ?Membre $membre = null;

    public function __construct()
    {
        $this->rendezVouses = new ArrayCollection();
        $this->operations = new ArrayCollection();
        $this->maladies = new ArrayCollection();
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

    public function getRace(): ?string
    {
        return $this->race;
    }

    public function setRace(string $race): self
    {
        $this->race = $race;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getAge(): ?string
    {
        return $this->age;
    }

    public function setAge(string $age): self
    {
        $this->age = $age;

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

    /**
     * @return Collection<int, RendezVous>
     */
    public function getRendezVouses(): Collection
    {
        return $this->rendezVouses;
    }

    public function addRendezVouse(RendezVous $rendezVouse): self
    {
        if (!$this->rendezVouses->contains($rendezVouse)) {
            $this->rendezVouses->add($rendezVouse);
            $rendezVouse->setAnimal($this);
        }

        return $this;
    }

    public function removeRendezVouse(RendezVous $rendezVouse): self
    {
        if ($this->rendezVouses->removeElement($rendezVouse)) {
            // set the owning side to null (unless already changed)
            if ($rendezVouse->getAnimal() === $this) {
                $rendezVouse->setAnimal(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Operation>
     */
    public function getOperations(): Collection
    {
        return $this->operations;
    }

    public function addOperation(Operation $operation): self
    {
        if (!$this->operations->contains($operation)) {
            $this->operations->add($operation);
            $operation->setAnimal($this);
        }

        return $this;
    }

    public function removeOperation(Operation $operation): self
    {
        if ($this->operations->removeElement($operation)) {
            // set the owning side to null (unless already changed)
            if ($operation->getAnimal() === $this) {
                $operation->setAnimal(null);
            }
        }

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

    /**
     * @return Collection<int, Maladie>
     */
    public function getMaladies(): Collection
    {
        return $this->maladies;
    }

    public function addMalady(Maladie $malady): self
    {
        if (!$this->maladies->contains($malady)) {
            $this->maladies->add($malady);
            $malady->setAnimal($this);
        }

        return $this;
    }

    public function removeMalady(Maladie $malady): self
    {
        if ($this->maladies->removeElement($malady)) {
            // set the owning side to null (unless already changed)
            if ($malady->getAnimal() === $this) {
                $malady->setAnimal(null);
            }
        }

        return $this;
    }

    public function getMembre(): ?Membre
    {
        return $this->membre;
    }

    public function setMembre(?Membre $membre): self
    {
        $this->membre = $membre;

        return $this;
    }
}

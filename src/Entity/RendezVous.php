<?php

namespace App\Entity;

use App\Repository\RendezVousRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: RendezVousRepository::class)]
class RendezVous
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\GreaterThanOrEqual("today",message: "le date n'est pas valide")]
    private ?\DateTimeInterface $date = null;


    #[ORM\Column(type: Types::INTEGER)]
    #[Assert\NotBlank(message:"La Duree du rendez vous  doit etre existe")]
    #[Assert\Positive(message:"La Duree du rendez vous  doit etre positive")]
    #[Assert\NotEqualTo(value: 0)]
    #[Assert\LessThanOrEqual(
        value: 2,
        message: "la duree maximal d'un rendez_vous est 2heures"
    )]
    private ?int $duree = null;

    #[ORM\ManyToOne(inversedBy: 'rendezVouses')]
    private ?Animal $animal = null;

    #[ORM\OneToMany(mappedBy: 'rendezvous', targetEntity: Membre::class)]
    private Collection $membres;


    public function __construct()
    {
        $this->membres = new ArrayCollection();
    }






    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getDuree(): ?int
    {
        return $this->duree;
    }

    /**
     * @param int|null $duree
     */
    public function setDuree(?int $duree): void
    {
        $this->duree = $duree;
    }

    public function __toString(): string
    {
        return $this->animal;
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

    /**
     * @return Collection<int, Membre>
     */
    public function getMembres(): Collection
    {
        return $this->membres;
    }

    public function addMembre(Membre $membre): self
    {
        if (!$this->membres->contains($membre)) {
            $this->membres->add($membre);
            $membre->setRendezvous($this);
        }

        return $this;
    }

    public function removeMembre(Membre $membre): self
    {
        if ($this->membres->removeElement($membre)) {
            // set the owning side to null (unless already changed)
            if ($membre->getRendezvous() === $this) {
                $membre->setRendezvous(null);
            }
        }

        return $this;
    }



}


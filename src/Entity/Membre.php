<?php

namespace App\Entity;

use App\Repository\MembreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MembreRepository::class)]
class Membre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_naiss = null;

    #[ORM\Column(length: 255)]
    private ?string $telephone = null;

    #[ORM\Column(length: 255)]
    private ?string $adress = null;

    #[ORM\Column(length: 255)]
    private ?string $role = null;

   
    
    #[ORM\ManyToOne(inversedBy: 'membres')]
    private ?RendezVous $rendezvous = null;
    
    #[ORM\ManyToOne(inversedBy: 'membres')]
    private ?Evenement $evenement = null;

    #[ORM\OneToMany(mappedBy: 'membre', targetEntity: Evenement::class)]
    private Collection $evenements;

   

    #[ORM\OneToMany(mappedBy: 'membre', targetEntity: Animal::class)]
    private Collection $animal;

    #[ORM\OneToMany(mappedBy: 'membre', targetEntity: Actualite::class)]
    private Collection $actualite;

    #[ORM\OneToMany(mappedBy: 'membre', targetEntity: Commentaire::class)]
    private Collection $commentaire;

    public function __construct()
    {
        $this->evenements = new ArrayCollection();
        $this->animal = new ArrayCollection();
        $this->actualite = new ArrayCollection();
        $this->commentaire = new ArrayCollection();
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

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

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getDateNaiss(): ?\DateTimeInterface
    {
        return $this->date_naiss;
    }

    public function setDateNaiss(\DateTimeInterface $date_naiss): self
    {
        $this->date_naiss = $date_naiss;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getEvenement(): ?Evenement
    {
        return $this->evenement;
    }

    public function setEvenement(?Evenement $evenement): self
    {
        $this->evenement = $evenement;

        return $this;
    }

    /**
     * @return Collection<int, Evenement>
     */
    public function getEvenements(): Collection
    {
        return $this->evenements;
    }

    public function addEvenement(Evenement $evenement): self
    {
        if (!$this->evenements->contains($evenement)) {
            $this->evenements->add($evenement);
            $evenement->setMembre($this);
        }

        return $this;
    }

    public function removeEvenement(Evenement $evenement): self
    {
        if ($this->evenements->removeElement($evenement)) {
            // set the owning side to null (unless already changed)
            if ($evenement->getMembre() === $this) {
                $evenement->setMembre(null);
            }
        }

        return $this;
    }

    public function getRendezvous(): ?RendezVous
    {
        return $this->rendezvous;
    }

    public function setRendezvous(?RendezVous $rendezvous): self
    {
        $this->rendezvous = $rendezvous;

        return $this;
    }

    /**
     * @return Collection<int, Animal>
     */
    public function getAnimal(): Collection
    {
        return $this->animal;
    }

    public function addAnimal(Animal $animal): self
    {
        if (!$this->animal->contains($animal)) {
            $this->animal->add($animal);
            $animal->setMembre($this);
        }

        return $this;
    }

    public function removeAnimal(Animal $animal): self
    {
        if ($this->animal->removeElement($animal)) {
            // set the owning side to null (unless already changed)
            if ($animal->getMembre() === $this) {
                $animal->setMembre(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Actualite>
     */
    public function getActualite(): Collection
    {
        return $this->actualite;
    }

    public function addActualite(Actualite $actualite): self
    {
        if (!$this->actualite->contains($actualite)) {
            $this->actualite->add($actualite);
            $actualite->setMembre($this);
        }

        return $this;
    }

    public function removeActualite(Actualite $actualite): self
    {
        if ($this->actualite->removeElement($actualite)) {
            // set the owning side to null (unless already changed)
            if ($actualite->getMembre() === $this) {
                $actualite->setMembre(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Commentaire>
     */
    public function getCommentaire(): Collection
    {
        return $this->commentaire;
    }

    public function addCommentaire(Commentaire $commentaire): self
    {
        if (!$this->commentaire->contains($commentaire)) {
            $this->commentaire->add($commentaire);
            $commentaire->setMembre($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaire->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getMembre() === $this) {
                $commentaire->setMembre(null);
            }
        }

        return $this;
    }
}

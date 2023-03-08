<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups("flora")]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"nom is required")]
    #[Groups("flora")]
    private ?string $Nom = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"prenom is required")]
    #[Groups("flora")]
    private ?string $Prenom = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"email is required")]
    #[Groups("flora")]
    private ?string $Email = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"password is required")]
    #[Groups("flora")]
    private ?string $Password = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups("flora")]
    private ?\DateTimeInterface $DateN = null;

    #[ORM\Column(type:"integer")]
    #[Assert\Length(min:"6",max:"8", minMessage:"votre num doit contenir au moins 8 chiffre")]
    #[Asset\Positive(message : 'le num de telephone doit etre positive')]
    #[Groups("flora")]
    private ?int $Numero = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"adresse is required")]
    #[Groups("flora")]
    private ?string $Adresse = null;

    #[Assert\NotBlank(message:"email is required")]
    #[Groups("flora")]
    #[ORM\Column(type: 'json')]
    private $role = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): self
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->Prenom;
    }

    public function setPrenom(string $Prenom): self
    {
        $this->Prenom = $Prenom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->Email;
    }

    public function setEmail(string $Email): self
    {
        $this->Email = $Email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->Password;
    }

    public function setPassword(string $Password): self
    {
        $this->Password = $Password;

        return $this;
    }

    public function getDateN(): ?\DateTimeInterface
    {
        return $this->DateN;
    }

    public function setDateN(\DateTimeInterface $DateN): self
    {
        $this->DateN = $DateN;

        return $this;
    }

    public function getNumero(): ?int
    {
        return $this->Numero;
    }

    public function setNumero(int $Numero): self
    {
        $this->Numero = $Numero;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->Adresse;
    }

    public function setAdresse(string $Adresse): self
    {
        $this->Adresse = $Adresse;

        return $this;
    }

    public function getRole(): array
    {
        $role = $this->role;
        // guarantee every user at least has ROLE_USER
        $role[] = 'ROLE_USER';

        return array_unique($role);
    }

    public function setRole(array $role): self
    {
        $this->role = $role;

        return $this;
    }
}

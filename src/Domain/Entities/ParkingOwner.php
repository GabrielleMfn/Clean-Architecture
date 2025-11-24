<?php

namespace App\Domain\Entities;

class ParkingOwner
{
    private ?int $id;
    private string $email;
    private string $password;
    private string $nom;
    private string $prenom;
    private array $parkings;
    private \DateTime $createdAt;

    public function __construct(
        string $email,
        string $password,
        string $nom,
        string $prenom,
        ?int $id = null
    ) {
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->parkings = [];
        $this->createdAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }

    public function getPrenom(): string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): void
    {
        $this->prenom = $prenom;
    }

    public function getParkings(): array
    {
        return $this->parkings;
    }

    public function addParking($parking): void
    {
        $this->parkings[] = $parking;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }
}

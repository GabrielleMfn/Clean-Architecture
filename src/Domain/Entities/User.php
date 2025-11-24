<?php

namespace App\Domain\Entities;

class User
{
    private ?int $id;
    private string $email;
    private string $password;
    private string $nom;
    private string $prenom;
    private array $reservations;
    private array $stationnements;
    private array $abonnements;
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
        $this->reservations = [];
        $this->stationnements = [];
        $this->abonnements = [];
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

    public function getReservations(): array
    {
        return $this->reservations;
    }

    public function addReservation($reservation): void
    {
        $this->reservations[] = $reservation;
    }

    public function getStationnements(): array
    {
        return $this->stationnements;
    }

    public function addStationnement($stationnement): void
    {
        $this->stationnements[] = $stationnement;
    }

    public function getAbonnements(): array
    {
        return $this->abonnements;
    }

    public function addAbonnement($abonnement): void
    {
        $this->abonnements[] = $abonnement;
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

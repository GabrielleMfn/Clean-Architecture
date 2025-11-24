<?php

namespace App\Domain\Entities;

use App\Domain\ValueObjects\GPSCoordinates;
use App\Domain\ValueObjects\OpeningHours;

class Parking
{
    private ?int $id;
    private int $ownerId;
    private GPSCoordinates $coordinates;
    private int $totalPlaces;
    private array $tarifs;
    private OpeningHours $openingHours;
    private array $reservations;
    private array $stationnements;
    private array $abonnements;
    private \DateTime $createdAt;

    public function __construct(
        int $ownerId,
        GPSCoordinates $coordinates,
        int $totalPlaces,
        array $tarifs,
        OpeningHours $openingHours,
        ?int $id = null
    ) {
        $this->id = $id;
        $this->ownerId = $ownerId;
        $this->coordinates = $coordinates;
        $this->totalPlaces = $totalPlaces;
        $this->tarifs = $tarifs;
        $this->openingHours = $openingHours;
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

    public function getOwnerId(): int
    {
        return $this->ownerId;
    }

    public function setOwnerId(int $ownerId): void
    {
        $this->ownerId = $ownerId;
    }

    public function getCoordinates(): GPSCoordinates
    {
        return $this->coordinates;
    }

    public function setCoordinates(GPSCoordinates $coordinates): void
    {
        $this->coordinates = $coordinates;
    }

    public function getTotalPlaces(): int
    {
        return $this->totalPlaces;
    }

    public function setTotalPlaces(int $totalPlaces): void
    {
        $this->totalPlaces = $totalPlaces;
    }

    public function getTarifs(): array
    {
        return $this->tarifs;
    }

    public function setTarifs(array $tarifs): void
    {
        $this->tarifs = $tarifs;
    }

    public function getOpeningHours(): OpeningHours
    {
        return $this->openingHours;
    }

    public function setOpeningHours(OpeningHours $openingHours): void
    {
        $this->openingHours = $openingHours;
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

    public function calculateAvailablePlaces(int $timestamp): int
    {
        $occupied = 0;
        
        foreach ($this->reservations as $reservation) {
            if ($reservation->isActiveAt($timestamp)) {
                $occupied++;
            }
        }
        
        foreach ($this->stationnements as $stationnement) {
            if ($stationnement->isActiveAt($timestamp)) {
                $occupied++;
            }
        }
        
        foreach ($this->abonnements as $abonnement) {
            if ($abonnement->isActiveAt($timestamp)) {
                $occupied++;
            }
        }
        
        return $this->totalPlaces - $occupied;
    }
}

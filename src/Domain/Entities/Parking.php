<?php

namespace App\Domain\Entities;

use App\Domain\ValueObjects\GPSCoordinates;
use App\Domain\ValueObjects\OpeningHours;
use App\Domain\ValueObjects\TarifCollection;

class Parking
{
    private ?int $id;
    private int $ownerId;
    private GPSCoordinates $coordinates;
    private int $totalPlaces;
    private TarifCollection $tarifs;
    private OpeningHours $openingHours;
    private \DateTimeImmutable $createdAt;

    public function __construct(
        int $ownerId,
        GPSCoordinates $coordinates,
        int $totalPlaces,
        TarifCollection $tarifs,
        OpeningHours $openingHours,
        \DateTimeImmutable $createdAt,
        ?int $id = null
    ) {
        $this->validateOwnerId($ownerId);
        $this->validateTotalPlaces($totalPlaces);

        $this->id = $id;
        $this->ownerId = $ownerId;
        $this->coordinates = $coordinates;
        $this->totalPlaces = $totalPlaces;
        $this->tarifs = $tarifs;
        $this->openingHours = $openingHours;
        $this->createdAt = $createdAt;
    }

    private function validateOwnerId(int $ownerId): void
    {
        if ($ownerId <= 0) {
            throw new \InvalidArgumentException("L'ID du proprietaire doit etre positif");
        }
    }

    private function validateTotalPlaces(int $totalPlaces): void
    {
        if ($totalPlaces <= 0) {
            throw new \InvalidArgumentException("Le nombre de places doit etre positif");
        }
        if ($totalPlaces > 10000) {
            throw new \InvalidArgumentException("Le nombre de places ne peut pas depasser 10000");
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOwnerId(): int
    {
        return $this->ownerId;
    }

    public function getCoordinates(): GPSCoordinates
    {
        return $this->coordinates;
    }

    public function getTotalPlaces(): int
    {
        return $this->totalPlaces;
    }

    public function updateTotalPlaces(int $totalPlaces): void
    {
        $this->validateTotalPlaces($totalPlaces);
        $this->totalPlaces = $totalPlaces;
    }

    public function getTarifs(): TarifCollection
    {
        return $this->tarifs;
    }

    public function updateTarifs(TarifCollection $tarifs): void
    {
        $this->tarifs = $tarifs;
    }

    public function hasAvailablePlaces(int $occupiedPlaces): bool
    {
        return $occupiedPlaces < $this->totalPlaces;
    }

    public function canAccommodate(int $requestedPlaces, int $currentOccupied): bool
    {
        return ($currentOccupied + $requestedPlaces) <= $this->totalPlaces;
    }

    public function isOpenAt(\DateTimeImmutable $dateTime): bool
    {
        return $this->openingHours->isOpenAt($dateTime);
    }

    public function isOpenDuring(\DateTimeImmutable $startDateTime, \DateTimeImmutable $endDateTime): bool
    {
        return $this->openingHours->isOpenDuring($startDateTime, $endDateTime);
    }

    public function belongsToOwner(int $ownerId): bool
    {
        return $this->ownerId === $ownerId;
    }

    public function getOpeningHours(): OpeningHours
    {
        return $this->openingHours;
    }

    public function updateOpeningHours(OpeningHours $openingHours): void
    {
        $this->openingHours = $openingHours;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}

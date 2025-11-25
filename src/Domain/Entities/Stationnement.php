<?php

namespace App\Domain\Entities;

use App\Domain\ValueObjects\Price;

class Stationnement
{
    private const PENALTY_AMOUNT = 20.0;

    private ?int $id;
    private int $userId;
    private int $parkingId;
    private ?int $reservationId;
    private \DateTimeImmutable $startTime;
    private ?\DateTimeImmutable $endTime;
    private ?Price $price;
    private bool $hasPenalty;
    private float $penaltyAmount;
    private \DateTimeImmutable $createdAt;

    public function __construct(
        int $userId,
        int $parkingId,
        \DateTimeImmutable $startTime,
        \DateTimeImmutable $createdAt,
        ?int $reservationId = null,
        ?int $id = null
    ) {
        $this->validateUserId($userId);
        $this->validateParkingId($parkingId);

        $this->id = $id;
        $this->userId = $userId;
        $this->parkingId = $parkingId;
        $this->reservationId = $reservationId;
        $this->startTime = $startTime;
        $this->endTime = null;
        $this->price = null;
        $this->hasPenalty = false;
        $this->penaltyAmount = 0.0;
        $this->createdAt = $createdAt;
    }

    private function validateUserId(int $userId): void
    {
        if ($userId <= 0) {
            throw new \InvalidArgumentException("L'ID utilisateur doit etre positif");
        }
    }

    private function validateParkingId(int $parkingId): void
    {
        if ($parkingId <= 0) {
            throw new \InvalidArgumentException("L'ID parking doit etre positif");
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getParkingId(): int
    {
        return $this->parkingId;
    }

    public function getReservationId(): ?int
    {
        return $this->reservationId;
    }

    public function getStartTime(): \DateTimeImmutable
    {
        return $this->startTime;
    }

    public function getEndTime(): ?\DateTimeImmutable
    {
        return $this->endTime;
    }

    public function getStartTimestamp(): int
    {
        return $this->startTime->getTimestamp();
    }

    public function getEndTimestamp(): ?int
    {
        return $this->endTime?->getTimestamp();
    }

    public function getPrice(): ?Price
    {
        return $this->price;
    }

    public function setPrice(Price $price): void
    {
        $this->price = $price;
    }

    public function getHasPenalty(): bool
    {
        return $this->hasPenalty;
    }

    public function getPenaltyAmount(): float
    {
        return $this->penaltyAmount;
    }

    public function applyPenalty(float $amount = self::PENALTY_AMOUNT): void
    {
        if ($this->hasPenalty) {
            throw new \DomainException("Une penalite a deja ete appliquee");
        }
        $this->hasPenalty = true;
        $this->penaltyAmount = $amount;
    }

    public function belongsToUser(int $userId): bool
    {
        return $this->userId === $userId;
    }

    public function isForParking(int $parkingId): bool
    {
        return $this->parkingId === $parkingId;
    }

    public function hasReservation(): bool
    {
        return $this->reservationId !== null;
    }

    public function isLinkedToReservation(int $reservationId): bool
    {
        return $this->reservationId === $reservationId;
    }

    public function exceedsReservation(\DateTimeImmutable $reservationEndTime): bool
    {
        if ($this->endTime === null) {
            return false;
        }
        return $this->endTime > $reservationEndTime;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function isActiveAt(\DateTimeImmutable $dateTime): bool
    {
        if ($this->endTime === null) {
            return $dateTime >= $this->startTime;
        }
        return $dateTime >= $this->startTime && $dateTime < $this->endTime;
    }

    public function getDuration(): ?int
    {
        if ($this->endTime === null) {
            return null;
        }
        return $this->endTime->getTimestamp() - $this->startTime->getTimestamp();
    }

    public function endStationnement(\DateTimeImmutable $endTime): void
    {
        if ($this->endTime !== null) {
            throw new \DomainException("Le stationnement est deja termine");
        }
        if ($endTime <= $this->startTime) {
            throw new \InvalidArgumentException("La date de fin doit etre posterieure a la date de debut");
        }
        $this->endTime = $endTime;
    }

    public function getTotalAmount(): float
    {
        if ($this->price === null) {
            return 0.0;
        }
        return $this->price->getAmount() + $this->penaltyAmount;
    }
}

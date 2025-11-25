<?php

namespace App\Domain\Entities;

use App\Domain\ValueObjects\Price;

class Reservation
{
    private ?int $id;
    private int $userId;
    private int $parkingId;
    private \DateTimeImmutable $startTime;
    private \DateTimeImmutable $endTime;
    private ?Price $price;
    private bool $isPaid;
    private \DateTimeImmutable $createdAt;

    public function __construct(
        int $userId,
        int $parkingId,
        \DateTimeImmutable $startTime,
        \DateTimeImmutable $endTime,
        \DateTimeImmutable $createdAt,
        ?int $id = null
    ) {
        $this->validateUserId($userId);
        $this->validateParkingId($parkingId);
        $this->validateTimeRange($startTime, $endTime);

        $this->id = $id;
        $this->userId = $userId;
        $this->parkingId = $parkingId;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->price = null;
        $this->isPaid = false;
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

    private function validateTimeRange(\DateTimeImmutable $startTime, \DateTimeImmutable $endTime): void
    {
        if ($startTime >= $endTime) {
            throw new \InvalidArgumentException("La date de debut doit etre anterieure a la date de fin");
        }

        $duration = $endTime->getTimestamp() - $startTime->getTimestamp();
        $minDuration = 900;
        if ($duration < $minDuration) {
            throw new \InvalidArgumentException("La duree minimale est de 15 minutes");
        }

        $maxDuration = 86400 * 7;
        if ($duration > $maxDuration) {
            throw new \InvalidArgumentException("La duree maximale est de 7 jours");
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

    public function getStartTime(): \DateTimeImmutable
    {
        return $this->startTime;
    }

    public function getEndTime(): \DateTimeImmutable
    {
        return $this->endTime;
    }

    public function getStartTimestamp(): int
    {
        return $this->startTime->getTimestamp();
    }

    public function getEndTimestamp(): int
    {
        return $this->endTime->getTimestamp();
    }

    public function getPrice(): ?Price
    {
        return $this->price;
    }

    public function setPrice(Price $price): void
    {
        $this->price = $price;
    }

    public function getIsPaid(): bool
    {
        return $this->isPaid;
    }

    public function markAsPaid(): void
    {
        $this->isPaid = true;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getDuration(): int
    {
        return $this->endTime->getTimestamp() - $this->startTime->getTimestamp();
    }

    public function getDurationInQuarters(): int
    {
        return (int)ceil($this->getDuration() / 900);
    }

    public function isActiveAt(\DateTimeImmutable $dateTime): bool
    {
        return $dateTime >= $this->startTime && $dateTime < $this->endTime;
    }

    public function hasStarted(\DateTimeImmutable $currentDateTime): bool
    {
        return $currentDateTime >= $this->startTime;
    }

    public function hasEnded(\DateTimeImmutable $currentDateTime): bool
    {
        return $currentDateTime >= $this->endTime;
    }

    public function overlaps(Reservation $other): bool
    {
        return !($this->endTime <= $other->startTime || $this->startTime >= $other->endTime);
    }

    public function belongsToUser(int $userId): bool
    {
        return $this->userId === $userId;
    }

    public function isForParking(int $parkingId): bool
    {
        return $this->parkingId === $parkingId;
    }
}

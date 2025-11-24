<?php

namespace App\Domain\Entities;

use App\Domain\ValueObjects\Price;

class Stationnement
{
    private ?int $id;
    private int $userId;
    private int $parkingId;
    private ?int $reservationId;
    private int $startTime;
    private ?int $endTime;
    private ?Price $price;
    private bool $hasPenalty;
    private float $penaltyAmount;
    private \DateTime $createdAt;

    public function __construct(
        int $userId,
        int $parkingId,
        int $startTime,
        ?int $reservationId = null,
        ?int $id = null
    ) {
        $this->id = $id;
        $this->userId = $userId;
        $this->parkingId = $parkingId;
        $this->reservationId = $reservationId;
        $this->startTime = $startTime;
        $this->endTime = null;
        $this->price = null;
        $this->hasPenalty = false;
        $this->penaltyAmount = 0.0;
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

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    public function getParkingId(): int
    {
        return $this->parkingId;
    }

    public function setParkingId(int $parkingId): void
    {
        $this->parkingId = $parkingId;
    }

    public function getReservationId(): ?int
    {
        return $this->reservationId;
    }

    public function setReservationId(?int $reservationId): void
    {
        $this->reservationId = $reservationId;
    }

    public function getStartTime(): int
    {
        return $this->startTime;
    }

    public function setStartTime(int $startTime): void
    {
        $this->startTime = $startTime;
    }

    public function getEndTime(): ?int
    {
        return $this->endTime;
    }

    public function setEndTime(?int $endTime): void
    {
        $this->endTime = $endTime;
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

    public function setHasPenalty(bool $hasPenalty): void
    {
        $this->hasPenalty = $hasPenalty;
    }

    public function getPenaltyAmount(): float
    {
        return $this->penaltyAmount;
    }

    public function setPenaltyAmount(float $penaltyAmount): void
    {
        $this->penaltyAmount = $penaltyAmount;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function isActive(): bool
    {
        return $this->endTime === null;
    }

    public function isActiveAt(int $timestamp): bool
    {
        if ($this->endTime === null) {
            return $timestamp >= $this->startTime;
        }
        return $timestamp >= $this->startTime && $timestamp < $this->endTime;
    }

    public function getDuration(): ?int
    {
        if ($this->endTime === null) {
            return null;
        }
        return $this->endTime - $this->startTime;
    }

    public function endStationnement(int $endTime): void
    {
        $this->endTime = $endTime;
    }
}

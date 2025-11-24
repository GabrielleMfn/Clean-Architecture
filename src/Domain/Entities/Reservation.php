<?php

namespace App\Domain\Entities;

use App\Domain\ValueObjects\Price;

class Reservation
{
    private ?int $id;
    private int $userId;
    private int $parkingId;
    private int $startTime;
    private int $endTime;
    private ?Price $price;
    private bool $isPaid;
    private \DateTime $createdAt;

    public function __construct(
        int $userId,
        int $parkingId,
        int $startTime,
        int $endTime,
        ?int $id = null
    ) {
        $this->id = $id;
        $this->userId = $userId;
        $this->parkingId = $parkingId;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->price = null;
        $this->isPaid = false;
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

    public function getStartTime(): int
    {
        return $this->startTime;
    }

    public function setStartTime(int $startTime): void
    {
        $this->startTime = $startTime;
    }

    public function getEndTime(): int
    {
        return $this->endTime;
    }

    public function setEndTime(int $endTime): void
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

    public function getIsPaid(): bool
    {
        return $this->isPaid;
    }

    public function setIsPaid(bool $isPaid): void
    {
        $this->isPaid = $isPaid;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getDuration(): int
    {
        return $this->endTime - $this->startTime;
    }

    public function isActiveAt(int $timestamp): bool
    {
        return $timestamp >= $this->startTime && $timestamp < $this->endTime;
    }

    public function isActive(): bool
    {
        $now = time();
        return $now >= $this->startTime && $now < $this->endTime;
    }

    public function hasStarted(): bool
    {
        return time() >= $this->startTime;
    }

    public function hasEnded(): bool
    {
        return time() >= $this->endTime;
    }
}

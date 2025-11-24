<?php

namespace App\Domain\Entities;

use App\Domain\ValueObjects\Price;
use App\Domain\ValueObjects\TimeSlot;

class Abonnement
{
    private ?int $id;
    private int $userId;
    private int $parkingId;
    private string $type;
    private array $timeSlots;
    private int $startDate;
    private int $endDate;
    private Price $price;
    private bool $isPaid;
    private \DateTime $createdAt;

    public function __construct(
        int $userId,
        int $parkingId,
        string $type,
        array $timeSlots,
        int $startDate,
        int $endDate,
        Price $price,
        ?int $id = null
    ) {
        $this->id = $id;
        $this->userId = $userId;
        $this->parkingId = $parkingId;
        $this->type = $type;
        $this->timeSlots = $timeSlots;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->price = $price;
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

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function getTimeSlots(): array
    {
        return $this->timeSlots;
    }

    public function setTimeSlots(array $timeSlots): void
    {
        $this->timeSlots = $timeSlots;
    }

    public function getStartDate(): int
    {
        return $this->startDate;
    }

    public function setStartDate(int $startDate): void
    {
        $this->startDate = $startDate;
    }

    public function getEndDate(): int
    {
        return $this->endDate;
    }

    public function setEndDate(int $endDate): void
    {
        $this->endDate = $endDate;
    }

    public function getPrice(): Price
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

    public function isActive(): bool
    {
        $now = time();
        return $now >= $this->startDate && $now <= $this->endDate;
    }

    public function isActiveAt(int $timestamp): bool
    {
        if ($timestamp < $this->startDate || $timestamp > $this->endDate) {
            return false;
        }

        $dayOfWeek = date('N', $timestamp);
        $timeOfDay = (int)date('H', $timestamp) * 3600 + (int)date('i', $timestamp) * 60;

        foreach ($this->timeSlots as $slot) {
            if ($slot->isActiveAt($dayOfWeek, $timeOfDay)) {
                return true;
            }
        }

        return false;
    }

    public function getDurationInMonths(): int
    {
        $start = new \DateTime('@' . $this->startDate);
        $end = new \DateTime('@' . $this->endDate);
        $interval = $start->diff($end);
        return $interval->m + ($interval->y * 12);
    }
}

<?php

namespace App\Domain\Entities;

use App\Domain\ValueObjects\Price;
use App\Domain\ValueObjects\TimeSlot;

class Abonnement
{
    public const TYPE_TOTAL = 'total';
    public const TYPE_WEEKEND = 'weekend';
    public const TYPE_SOIR = 'soir';
    public const TYPE_SPECIFIQUE = 'specifique';

    public const MIN_DURATION_MONTHS = 1;
    public const MAX_DURATION_MONTHS = 12;

    private ?int $id;
    private int $userId;
    private int $parkingId;
    private string $type;
    private array $timeSlots;
    private \DateTimeImmutable $startDate;
    private \DateTimeImmutable $endDate;
    private Price $price;
    private bool $isPaid;
    private \DateTimeImmutable $createdAt;

    public function __construct(
        int $userId,
        int $parkingId,
        string $type,
        array $timeSlots,
        \DateTimeImmutable $startDate,
        \DateTimeImmutable $endDate,
        Price $price,
        \DateTimeImmutable $createdAt,
        ?int $id = null
    ) {
        $this->validateUserId($userId);
        $this->validateParkingId($parkingId);
        $this->validateType($type);
        $this->validateTimeSlots($timeSlots);
        $this->validateDateRange($startDate, $endDate);

        $this->id = $id;
        $this->userId = $userId;
        $this->parkingId = $parkingId;
        $this->type = $type;
        $this->timeSlots = $timeSlots;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->price = $price;
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

    private function validateType(string $type): void
    {
        $validTypes = [self::TYPE_TOTAL, self::TYPE_WEEKEND, self::TYPE_SOIR, self::TYPE_SPECIFIQUE];
        if (!in_array($type, $validTypes)) {
            throw new \InvalidArgumentException("Type d'abonnement invalide");
        }
    }

    private function validateTimeSlots(array $timeSlots): void
    {
        if (empty($timeSlots)) {
            throw new \InvalidArgumentException("Au moins un creneau horaire est requis");
        }
        foreach ($timeSlots as $slot) {
            if (!($slot instanceof TimeSlot)) {
                throw new \InvalidArgumentException("Tous les creneaux doivent etre des instances de TimeSlot");
            }
        }
    }

    private function validateDateRange(\DateTimeImmutable $startDate, \DateTimeImmutable $endDate): void
    {
        if ($startDate >= $endDate) {
            throw new \InvalidArgumentException("La date de debut doit etre anterieure a la date de fin");
        }

        $durationInSeconds = $endDate->getTimestamp() - $startDate->getTimestamp();
        $minDurationSeconds = self::MIN_DURATION_MONTHS * 30 * 86400;
        $maxDurationSeconds = self::MAX_DURATION_MONTHS * 30 * 86400;

        if ($durationInSeconds < $minDurationSeconds) {
            throw new \InvalidArgumentException("La duree minimale est de 1 mois");
        }

        if ($durationInSeconds > $maxDurationSeconds) {
            throw new \InvalidArgumentException("La duree maximale est de 12 mois");
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

    public function getType(): string
    {
        return $this->type;
    }

    public function getTimeSlots(): array
    {
        return $this->timeSlots;
    }

    public function getStartDate(): \DateTimeImmutable
    {
        return $this->startDate;
    }

    public function getEndDate(): \DateTimeImmutable
    {
        return $this->endDate;
    }

    public function getStartTimestamp(): int
    {
        return $this->startDate->getTimestamp();
    }

    public function getEndTimestamp(): int
    {
        return $this->endDate->getTimestamp();
    }

    public function getPrice(): Price
    {
        return $this->price;
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

    public function isValidAt(\DateTimeImmutable $dateTime): bool
    {
        return $dateTime >= $this->startDate && $dateTime <= $this->endDate;
    }

    public function coversTimeSlot(int $dayOfWeek, int $timeOfDay): bool
    {
        foreach ($this->timeSlots as $slot) {
            if ($slot->isActiveAt($dayOfWeek, $timeOfDay)) {
                return true;
            }
        }

        return false;
    }

    public function getDurationInMonths(): int
    {
        $interval = $this->startDate->diff($this->endDate);
        return $interval->m + ($interval->y * 12);
    }

    public function belongsToUser(int $userId): bool
    {
        return $this->userId === $userId;
    }

    public function isForParking(int $parkingId): bool
    {
        return $this->parkingId === $parkingId;
    }

    public function isTotalAccess(): bool
    {
        return $this->type === self::TYPE_TOTAL;
    }

    public function getRemainingDays(\DateTimeImmutable $currentDateTime): int
    {
        if ($currentDateTime > $this->endDate) {
            return 0;
        }
        $interval = $currentDateTime->diff($this->endDate);
        return $interval->days;
    }
}

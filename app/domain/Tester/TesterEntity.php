<?php

namespace App\Domain\Tester;

use DateTimeImmutable;

final class TesterEntity
{
    public function __construct(
        private ?int $id,
        private ?int $userId,
        private int $specDocSheetId,
        private DateTimeImmutable $createdAt,
        private ?string $userName,
    ) {
        $this->id             = $id;
        $this->userId         = $userId;
        $this->specDocSheetId = $specDocSheetId;
        $this->createdAt      = $createdAt;
        $this->userName       = $userName;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function getSpecDocSheetId(): int
    {
        return $this->specDocSheetId;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * プリミティブ型の要素で構成された配列に変換
     *
     * @return array<string, int|null|string>
     */
    public function toArray(): array
    {
        return [
            'id'             => $this->id,
            'userId'         => $this->userId,
            'specDocSheetId' => $this->specDocSheetId,
            'createdAt'      => $this->createdAt->format('Y-m-d H:i:s'),
            'userName'       => $this->userName,
        ];
    }
}

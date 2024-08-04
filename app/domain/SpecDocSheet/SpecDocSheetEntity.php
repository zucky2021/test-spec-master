<?php

namespace App\Domain\SpecDocSheet;

use App\Domain\SpecDocSheet\ValueObject\StatusId;
use DateTimeImmutable;

/**
 * シート(実施環境毎の仕様書)Entity
 */
final class SpecDocSheetEntity
{
    public function __construct(
        private ?int $id,
        private int $specDocId,
        private int $execEnvId,
        private StatusId $statusId,
        private DateTimeImmutable $updatedAt,
    ) {
        $this->id        = $id;
        $this->specDocId = $specDocId;
        $this->execEnvId = $execEnvId;
        $this->statusId  = $statusId;
        $this->updatedAt = $updatedAt;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSpecDocId(): int
    {
        return $this->specDocId;
    }

    public function getExecEnvId(): int
    {
        return $this->execEnvId;
    }

    public function getStatusId(): StatusId
    {
        return $this->statusId;
    }

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }

    /**
     * Viewに渡すために配列に変換
     *
     * @return array<string, int|null|string>
     */
    public function toArray(): array
    {
        return [
            'id'        => $this->id,
            'specDocId' => $this->specDocId,
            'execEnvId' => $this->execEnvId,
            'statusId'  => $this->statusId->value(),
            'updatedAt' => $this->updatedAt->format('Y-m-d H:i:s'),
        ];
    }
}

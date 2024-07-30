<?php

namespace App\Domain\SpecificationDocument;

use App\Domain\SpecificationDocument\ValueObject\Summary;
use App\Domain\SpecificationDocument\ValueObject\Title;
use DateTimeImmutable;

/**
 * 仕様書Entity
 */
final class SpecificationDocumentEntity
{
    private ?int $id;
    private int $projectId;
    private int $userId;
    private Title $title;
    private Summary $summary;
    private DateTimeImmutable $updatedAt;

    public function __construct(
        ?int $id,
        int $projectId,
        int $userId,
        Title $title,
        Summary $summary,
        DateTimeImmutable $updatedAt,
    ) {
        $this->id        = $id;
        $this->projectId = $projectId;
        $this->userId    = $userId;
        $this->title     = $title;
        $this->summary   = $summary;
        $this->updatedAt = $updatedAt;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProjectId(): int
    {
        return $this->projectId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getTitle(): Title
    {
        return $this->title;
    }

    public function getSummary(): Summary
    {
        return $this->summary;
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
            'projectId' => $this->projectId,
            'userId'    => $this->userId,
            'title'     => $this->title->value(),
            'summary'   => $this->summary->value(),
            'updatedAt' => $this->updatedAt->format('Y-m-d H:i:s'),
        ];
    }
}

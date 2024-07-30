<?php

namespace App\Domain\SpecificationDocument;

use DateTimeImmutable;

/**
 * 仕様書Data Transfer Object(データの受け渡し専用クラス)
 */
final class SpecificationDocumentDto
{
    public ?int $id;
    public int $projectId;
    public int $userId;
    public string $title;
    public string $summary;
    public DateTimeImmutable $updatedAt;

    public function __construct(
        ?int $id,
        int $projectId,
        int $userId,
        string $title,
        string $summary,
        DateTimeImmutable $updatedAt,
    ) {
        $this->id        = $id;
        $this->projectId = $projectId;
        $this->userId    = $userId;
        $this->title     = $title;
        $this->summary   = $summary;
        $this->updatedAt = $updatedAt;
    }
}

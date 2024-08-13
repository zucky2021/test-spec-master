<?php

namespace App\Domain\SpecificationDocument;

/**
 * 仕様書Data Transfer Object(データの受け渡し専用クラス)
 */
final class SpecificationDocumentDto
{
    public function __construct(
        public ?int $id,
        public int $projectId,
        public int $userId,
        public string $title,
        public string $summary,
        public string $updatedAt,
    ) {
        $this->id        = $id;
        $this->projectId = $projectId;
        $this->userId    = $userId;
        $this->title     = $title;
        $this->summary   = $summary;
        $this->updatedAt = $updatedAt;
    }
}

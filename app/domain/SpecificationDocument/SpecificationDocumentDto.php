<?php

namespace App\Domain\SpecificationDocument;

/**
 * 仕様書Data Transfer Object(データの受け渡し専用クラス)
 */
final class SpecificationDocumentDto
{
    public function __construct(
        public ?int $id,
        public int $project_id,
        public int $user_id,
        public string $title,
        public string $summary,
        public string $updated_at,
    ) {
        $this->id         = $id;
        $this->project_id = $project_id;
        $this->user_id    = $user_id;
        $this->title      = $title;
        $this->summary    = $summary;
        $this->updated_at = $updated_at;
    }
}

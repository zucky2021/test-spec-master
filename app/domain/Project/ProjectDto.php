<?php

namespace App\Domain\Project;

/**
 * プロジェクトData Transfer Object(データの受け渡し専用クラス)
 */
final class ProjectDto
{
    public function __construct(
        public ?int $id,
        public int $departmentId,
        public string $name,
        public string $summary,
    ) {
        $this->id           = $id;
        $this->departmentId = $departmentId;
        $this->name         = $name;
        $this->summary      = $summary;
    }
}

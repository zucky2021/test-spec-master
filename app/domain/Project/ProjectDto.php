<?php

namespace App\Domain\Project;

/**
 * プロジェクトData Transfer Object(データの受け渡し専用クラス)
 */
final class ProjectDto
{
    public function __construct(
        public ?int $id,
        public int $department_id,
        public string $name,
        public string $summary,
    ) {
        $this->id            = $id;
        $this->department_id = $department_id;
        $this->name          = $name;
        $this->summary       = $summary;
    }
}

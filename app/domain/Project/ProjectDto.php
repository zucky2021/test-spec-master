<?php

namespace App\Domain\Project;

/**
 * プロジェクトData Transfer Object(データの受け渡し専用クラス)
 */
final class ProjectDto
{
    public ?int $id;
    public int $departmentId;
    public string $name;
    public string $summary;

    public function __construct(
        ?int $id,
        int $departmentId,
        string $name,
        string $summary,
    ) {
        $this->id           = $id;
        $this->departmentId = $departmentId;
        $this->name         = $name;
        $this->summary      = $summary;
    }
}

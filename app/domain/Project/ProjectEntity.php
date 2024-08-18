<?php

namespace App\Domain\Project;

use App\Domain\Project\ValueObject\Name;
use App\Domain\Project\ValueObject\Summary;

/**
 * プロジェクトentity
 */
final class ProjectEntity
{
    public function __construct(
        private ?int $id,
        private int $departmentId,
        private Name $name,
        private Summary $summary,
    ) {
        $this->id           = $id;
        $this->departmentId = $departmentId;
        $this->name         = $name;
        $this->summary      = $summary;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDepartmentId(): int
    {
        return $this->departmentId;
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function getSummary(): Summary
    {
        return $this->summary;
    }

    /**
     * Property to array
     *
     * @return array<string, int|null|string>
     */
    public function toArray(): array
    {
        return [
            'id'           => $this->id,
            'departmentId' => $this->departmentId,
            'name'         => $this->name->value(),
            'summary'      => $this->summary->value(),
        ];
    }
}

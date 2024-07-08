<?php

namespace App\Domain\Project;

use App\Domain\Project\ValueObject\Name;
use App\Domain\Project\ValueObject\Summary;
use DateTimeImmutable;

/**
 * プロジェクトentity
 */
final class Entity
{
    public function __construct(
        private int $id,
        private Name $name,
        private ?Summary $summary,
        private DateTimeImmutable $createdAt
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->summary = $summary;
        $this->createdAt = $createdAt;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function getSummary(): Summary
    {
        return $this->summary;
    }
}

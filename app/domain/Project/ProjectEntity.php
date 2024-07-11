<?php

namespace App\Domain\Project;

use App\Domain\Project\ValueObject\Name;
use App\Domain\Project\ValueObject\Summary;

/**
 * プロジェクトentity
 */
final class ProjectEntity
{
    private ?int $id;
    private int $department_id;
    private Name $name;
    private Summary $summary;

    public function __construct(
        ?int $id,
        int $department_id,
        Name $name,
        Summary $summary,
    ) {
        $this->id = $id;
        $this->department_id = $department_id;
        $this->name = $name;
        $this->summary = $summary;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDepartmentId(): int
    {
        return $this->department_id;
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
     * @return array
     */
    public function toArray(): array
    {
        $retArr = get_object_vars($this);
        $retArr['name'] = $this->getName()->value();
        $retArr['summary'] = $this->getSummary()->value();

        return $retArr;
    }
}

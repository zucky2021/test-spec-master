<?php

namespace App\Domain\Department;

use App\Domain\Department\ValueObject\Name;

/**
 * 部署entity
 */
final class DepartmentEntity
{
    private ?int $id;
    private Name $name;

    public function __construct(
        ?int $id,
        Name $name,
    ) {
        $this->id   = $id;
        $this->name = $name;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): Name
    {
        return $this->name;
    }

    /**
     * Property to array
     *
     * @return array<string, int|null|string>
     */
    public function toArray(): array
    {
        return [
            'id'   => $this->id,
            'name' => $this->name->value(),
        ];
    }
}

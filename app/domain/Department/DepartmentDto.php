<?php

namespace App\Domain\Department;

/**
 * 部署Data Transfer Object(データの受け渡し専用クラス)
 */
final class DepartmentDto
{
    public ?int $id;
    public string $name;

    public function __construct(
        ?int $id,
        string $name,
    ) {
        $this->id   = $id;
        $this->name = $name;
    }
}

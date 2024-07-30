<?php

namespace App\Domain\Department;

use App\Domain\Department\ValueObject\Name;

/**
 * Department domain object generation
 */
final class DepartmentFactory
{
    public static function create(DepartmentDto $dto): DepartmentEntity
    {
        return new DepartmentEntity(
            $dto->id,
            new Name($dto->name),
        );
    }
}

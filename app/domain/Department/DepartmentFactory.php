<?php

namespace App\Domain\Department;

use App\Domain\Department\ValueObject\Name;

/**
 * Department domain object generation
 */
final class DepartmentFactory
{
    /**
     * Generating domain objects from arrays
     *
     * @param array<string, mixed> $data
     * @return DepartmentEntity
     */
    public static function create(array $data): DepartmentEntity
    {
        return new DepartmentEntity(
            isset($data['id']) ? (int) $data['id'] : null,
            new Name($data['name'])
        );
    }
}

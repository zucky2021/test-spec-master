<?php

namespace App\Domain\Department;

/**
 * Interface with external(DB)
 */
interface DepartmentRepositoryInterface
{
    public const TABLE_NAME = 'departments';

    /**
     * 全ての部署を取得
     *
     * @return DepartmentDto[]
     */
    public function findAll(): array;
}

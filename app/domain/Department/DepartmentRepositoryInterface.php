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
     * @return DepartmentEntity[]
     */
    public function findAll(): array;
}

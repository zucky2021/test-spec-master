<?php

namespace App\Domain\Department;

interface DepartmentRepositoryInterface
{
    const TABLE_NAME = 'departments';

    /**
     * 全ての部署を取得
     *
     * @return array
     */
    public function findAll(): array;
}
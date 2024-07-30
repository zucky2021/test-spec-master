<?php

namespace App\UseCases\Department;

use App\Domain\Department\DepartmentEntity;
use App\Domain\Department\DepartmentRepositoryInterface;

/**
 * Use cases for department acquisition
 */
final class DepartmentFindAction
{
    private DepartmentRepositoryInterface $repository;

    public function __construct(DepartmentRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * 部署を全て取得
     *
     * @return DepartmentEntity[]
     */
    public function findAll(): array
    {
        return $this->repository->findAll();
    }
}

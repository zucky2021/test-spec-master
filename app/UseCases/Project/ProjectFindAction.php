<?php

namespace App\UseCases\Project;

use App\Domain\Project\ProjectEntity;
use App\Domain\Project\ProjectRepositoryInterface;

/**
 * Use cases for project acquisition
 */
final class ProjectFindAction
{
    private $repository;

    public function __construct(ProjectRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * プロジェクトを取得
     *
     * @return ProjectEntity[]
     */
    public function findAll(): array
    {
        return $this->repository->findAll();
    }
}

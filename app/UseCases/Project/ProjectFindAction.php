<?php

namespace App\UseCases\Project;

use App\Domain\Project\ProjectDto;
use App\Domain\Project\ProjectRepositoryInterface;

/**
 * Use cases for project acquisition
 */
final class ProjectFindAction
{
    private ProjectRepositoryInterface $repository;

    public function __construct(ProjectRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function findById(int $id): ?ProjectDto
    {
        return $this->repository->findById($id);
    }

    /**
     * プロジェクトを取得
     *
     * @return ProjectDto[]
     */
    public function findAll(): array
    {
        return $this->repository->findAll();
    }

    public function exists(int $projectId): bool
    {
        return $this->repository->exists($projectId);
    }
}

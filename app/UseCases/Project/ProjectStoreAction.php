<?php

namespace App\UseCases\Project;

use App\Domain\Project\ProjectDto;
use App\Domain\Project\ProjectRepositoryInterface;

final class ProjectStoreAction
{
    private ProjectRepositoryInterface $repository;

    public function __construct(ProjectRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function store(ProjectDto $dto): int
    {
        return $this->repository->store($dto);
    }
}

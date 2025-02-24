<?php

namespace App\UseCases\Project;

use App\Domain\Project\ProjectDto;
use App\Domain\Project\ProjectRepositoryInterface;

final class ProjectUpdateAction
{
    private ProjectRepositoryInterface $repository;

    public function __construct(ProjectRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * 更新
     *
     * @param ProjectDto $dto
     * @return void
     */
    public function update(ProjectDto $dto): void
    {
        $this->repository->update($dto);
    }
}

<?php

namespace App\UseCases\Project;

use App\Domain\Project\ProjectRepositoryInterface;

final class ProjectDeleteAction
{
    private ProjectRepositoryInterface $repository;

    public function __construct(ProjectRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * 論理削除
     *
     * @param integer $id PK
     * @return void
     */
    public function delete(int $id): void
    {
        $this->repository->delete($id);
    }
}

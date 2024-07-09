<?php

namespace App\Domain\Project;

interface ProjectRepositoryInterface
{
    const TABLE_NAME = 'projects';

    /**
     * 全てのプロジェクトを取得
     *
     * @return ProjectEntity[]
     */
    public function findAll(): array;
}

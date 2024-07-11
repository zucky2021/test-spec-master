<?php

namespace App\Domain\Project;

/**
 * Interface with external(DB)
 */
interface ProjectRepositoryInterface
{
    public const TABLE_NAME = 'projects';

    /**
     * 全てのプロジェクトを取得
     *
     * @return ProjectEntity[]
     */
    public function findAll(): array;
}

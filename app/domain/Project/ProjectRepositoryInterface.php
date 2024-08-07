<?php

namespace App\Domain\Project;

/**
 * Interface with external(DB)
 */
interface ProjectRepositoryInterface
{
    public const TABLE_NAME = 'projects';

    public function findById(int $id): ?ProjectDto;

    /**
     * 全てのプロジェクトを取得
     *
     * @return ProjectEntity[]
     */
    public function findAll(): array;

    /**
     * PKの存在を検証
     *
     * @param int $projectId
     * @return bool
     */
    public function exists(int $projectId): bool;
}

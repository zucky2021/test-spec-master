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
     * @return ProjectDto[]
     */
    public function findAll(): array;

    /**
     * PKの存在を検証
     *
     * @param int $projectId
     * @return bool
     */
    public function exists(int $projectId): bool;

    /**
     * 新規作成
     *
     * @param ProjectDto $dto
     * @return integer insert PK
     */
    public function store(ProjectDto $dto): int;

    /**
     * 更新
     *
     * @param ProjectDto $dto
     * @return void
     */
    public function update(ProjectDto $dto): void;

    /**
     * 論理削除
     *
     * @param integer $id
     * @return void
     */
    public function delete(int $id): void;
}

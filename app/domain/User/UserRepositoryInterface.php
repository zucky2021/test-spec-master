<?php

namespace App\Domain\User;

/**
 * Interface with external(DB)
 */
interface UserRepositoryInterface
{
    public const TABLE_NAME = 'users';

    /**
     * 全てのユーザーを取得
     *
     * @return UserDto[]
     */
    public function findAll(): array;

    /**
     * 管理者権限の有無を確認
     *
     * @param integer $id PK
     * @return boolean
     */
    public function isAdmin(int $id): bool;

    /**
     * 管理者権限を更新
     *
     * @param integer $id PK
     * @param boolean $isAdmin New value
     * @return void
     */
    public function updateIsAdmin(int $id, bool $isAdmin): void;
}

<?php

namespace App\Domain\User;

/**
 * Interface with external(DB)
 */
interface UserRepositoryInterface
{
    public const TABLE_NAME = 'users';

    /**
     * 管理者権限の有無を確認
     *
     * @param integer $id PK
     * @return boolean
     */
    public function isAdmin(int $id): bool;
}

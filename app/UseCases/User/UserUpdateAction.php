<?php

namespace App\UseCases\User;

use App\Domain\User\UserRepositoryInterface;

final class UserUpdateAction
{
    private UserRepositoryInterface $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * 管理者権限更新処理
     *
     * @param integer $id
     * @param boolean $isAdmin
     * @return void
     */
    public function updateIsAdmin(int $id, bool $isAdmin): void
    {
        // TODO:自分の管理者権限を編集拒否

        $this->repository->updateIsAdmin($id, $isAdmin);
    }
}

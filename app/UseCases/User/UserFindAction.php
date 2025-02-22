<?php

namespace App\UseCases\User;

use App\Domain\User\UserDto;
use App\Domain\User\UserRepositoryInterface;

final class UserFindAction
{
    private UserRepositoryInterface $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * 全てのユーザーを取得
     *
     * @return UserDto[]
     */
    public function findAll(): array
    {
        return $this->repository->findAll();
    }

    public function isAdmin(int $id): bool
    {
        return $this->repository->isAdmin($id);
    }
}

<?php

namespace App\UseCases\User;

use App\Domain\User\UserRepositoryInterface;

final class UserFindAction
{
    private UserRepositoryInterface $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function isAdmin(int $id): bool
    {
        return $this->repository->isAdmin($id);
    }
}

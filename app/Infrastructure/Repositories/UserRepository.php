<?php

namespace App\Infrastructure\Repositories;

use App\Domain\User\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;

final class UserRepository implements UserRepositoryInterface
{
    public function isAdmin(int $id): bool
    {
        return DB::table(UserRepositoryInterface::TABLE_NAME)
            ->where('id', $id)
            ->where('is_admin', true)
            ->exists();
    }
}

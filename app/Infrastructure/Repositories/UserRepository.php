<?php

namespace App\Infrastructure\Repositories;

use App\Domain\User\UserDto;
use App\Domain\User\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;
use stdClass;

final class UserRepository implements UserRepositoryInterface
{
    public function findAll(): array
    {
        /** @var UserDto[] */
        return DB::table(self::TABLE_NAME)
            ->get()
            ->map(function ($value) {
                /** @var stdClass $value */
                return new UserDto(
                    id: $value->id,
                    departmentId: $value->department_id,
                    name: $value->name,
                    email: $value->email,
                    password: $value->password,
                    isAdmin: $value->is_admin,
                );
            })
            ->toArray();
    }

    public function isAdmin(int $id): bool
    {
        return DB::table(self::TABLE_NAME)
            ->where('id', $id)
            ->where('is_admin', true)
            ->exists();
    }

    public function updateIsAdmin(int $id, bool $isAdmin): void
    {
        DB::table(self::TABLE_NAME)
            ->where('id', $id)
            ->update(['is_admin' => $isAdmin]);
    }
}

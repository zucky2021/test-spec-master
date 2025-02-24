<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Department\DepartmentDto;
use App\Domain\Department\DepartmentRepositoryInterface;
use Illuminate\Support\Facades\DB;
use stdClass;

final class DepartmentRepository implements DepartmentRepositoryInterface
{
    public function findAll(): array
    {
        /** @var DepartmentDto[] */
        return DB::table(self::TABLE_NAME)
            ->get()
            ->map(function ($value) {
                /** @var stdClass $value */
                return new DepartmentDto(
                    id: $value->id,
                    name: $value->name,
                );
            })
            ->toArray();
    }
}

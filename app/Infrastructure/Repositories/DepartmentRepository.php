<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Department\DepartmentDto;
use App\Domain\Department\DepartmentEntity;
use App\Domain\Department\DepartmentFactory;
use App\Domain\Department\DepartmentRepositoryInterface;
use Illuminate\Support\Facades\DB;
use stdClass;

final class DepartmentRepository implements DepartmentRepositoryInterface
{
    public function findAll(): array
    {
        /** @var DepartmentEntity[] */
        $entities = DB::table(DepartmentRepositoryInterface::TABLE_NAME)
            ->get()
            ->map(function ($value) {
                /** @var stdClass $value */
                $dto = new DepartmentDto(
                    id: $value->id,
                    name: $value->name,
                );

                return DepartmentFactory::create($dto);
            })
            ->toArray();

        return $entities;
    }
}

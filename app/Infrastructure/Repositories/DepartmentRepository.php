<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Department\DepartmentFactory;
use App\Domain\Department\DepartmentRepositoryInterface;
use Illuminate\Support\Facades\DB;

final class DepartmentRepository implements DepartmentRepositoryInterface
{
    public function findAll(): array
    {
        $departments = DB::table(DepartmentRepositoryInterface::TABLE_NAME)
            ->get()
            ->map(function ($department) {
                return DepartmentFactory::create((array) $department);
            });

        return $departments->toArray();
    }
}

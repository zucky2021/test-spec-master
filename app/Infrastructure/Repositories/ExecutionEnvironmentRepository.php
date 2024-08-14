<?php

namespace App\Infrastructure\Repositories;

use App\Domain\ExecutionEnvironment\ExecutionEnvironmentDto;
use App\Domain\ExecutionEnvironment\ExecutionEnvironmentRepositoryInterface;
use Illuminate\Support\Facades\DB;
use stdClass;

final class ExecutionEnvironmentRepository implements ExecutionEnvironmentRepositoryInterface
{
    public function findAll(): array
    {
        /** @var ExecutionEnvironmentDto[] */
        $dtoArr = DB::table(ExecutionEnvironmentRepositoryInterface::TABLE_NAME)
            ->get()
            ->map(function ($value) {
                /** @var stdClass $value */
                return new ExecutionEnvironmentDto(
                    id: $value->id,
                    name: $value->name,
                    orderNum: $value->order_num,
                    isDisplay: $value->is_display,
                );
            })
            ->toArray();

        return $dtoArr;
    }
}

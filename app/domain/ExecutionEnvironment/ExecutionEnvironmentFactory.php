<?php

namespace App\Domain\ExecutionEnvironment;

use App\Domain\ExecutionEnvironment\ValueObject\Name;
use App\Domain\ExecutionEnvironment\ValueObject\OrderNum;

/**
 * ExecutionEnvironment domain object generation
 */
final class ExecutionEnvironmentFactory
{
    public static function create(ExecutionEnvironmentDto $dto): ExecutionEnvironmentEntity
    {
        return new ExecutionEnvironmentEntity(
            $dto->id,
            new Name($dto->name),
            new OrderNum($dto->orderNum),
            $dto->isDisplay,
        );
    }
}

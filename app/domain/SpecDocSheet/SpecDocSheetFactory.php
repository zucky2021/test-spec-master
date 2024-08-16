<?php

namespace App\Domain\SpecDocSheet;

use App\Domain\ExecutionEnvironment\ValueObject\Name;
use App\Domain\SpecDocSheet\ValueObject\StatusId;
use DateTimeImmutable;

final class SpecDocSheetFactory
{
    public static function create(SpecDocSheetDto $dto): SpecDocSheetEntity
    {
        return new SpecDocSheetEntity(
            $dto->id,
            $dto->specDocId,
            $dto->execEnvId,
            new StatusId($dto->statusId),
            new DateTimeImmutable($dto->updatedAt),
            !empty($dto->execEnvName) ? new Name($dto->execEnvName) : null,
        );
    }
}

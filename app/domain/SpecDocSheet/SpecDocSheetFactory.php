<?php

namespace App\Domain\SpecDocSheet;

use App\Domain\SpecDocSheet\ValueObject\StatusId;

final class SpecDocSheetFactory
{
    public static function create(SpecDocSheetDto $dto): SpecDocSheetEntity
    {
        return new SpecDocSheetEntity(
            $dto->id,
            $dto->specDocId,
            $dto->execEnvId,
            new StatusId($dto->statusId),
            $dto->updatedAt,
        );
    }
}

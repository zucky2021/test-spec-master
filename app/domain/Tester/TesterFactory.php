<?php

namespace App\Domain\Tester;

use DateTimeImmutable;

final class TesterFactory
{
    public static function create(TesterDto $dto): TesterEntity
    {
        return new TesterEntity(
            id: $dto->id,
            userId: $dto->userId,
            specDocSheetId: $dto->specDocSheetId,
            createdAt: new DateTimeImmutable($dto->createdAt),
            userName: $dto->userName,
        );
    }
}

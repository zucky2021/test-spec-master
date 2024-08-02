<?php

namespace App\Domain\SpecDocItem;

use App\Domain\SpecDocItem\ValueObject\CheckDetail;
use App\Domain\SpecDocItem\ValueObject\Remark;
use App\Domain\SpecDocItem\ValueObject\StatusId;
use App\Domain\SpecDocItem\ValueObject\TargetArea;

final class SpecDocItemFactory
{
    public static function create(SpecDocItemDto $dto): SpecDocItemEntity
    {
        return new SpecDocItemEntity(
            $dto->id,
            $dto->specDocSheetId,
            new TargetArea($dto->targetArea),
            new CheckDetail($dto->checkDetail),
            !empty($dto->remark) ? new Remark($dto->remark) : null,
            new StatusId($dto->statusId),
        );
    }
}

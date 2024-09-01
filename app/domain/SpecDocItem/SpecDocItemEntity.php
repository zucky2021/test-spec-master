<?php

namespace App\Domain\SpecDocItem;

use App\Domain\SpecDocItem\ValueObject\CheckDetail;
use App\Domain\SpecDocItem\ValueObject\Remark;
use App\Domain\SpecDocItem\ValueObject\StatusId;
use App\Domain\SpecDocItem\ValueObject\TargetArea;

/**
 * テスト項目Entity
 */
final class SpecDocItemEntity
{
    public function __construct(
        private ?int $id,
        private int $specDocSheetId,
        private TargetArea $targetArea,
        private CheckDetail $checkDetail,
        private ?Remark $remark,
        private StatusId $statusId,
    ) {
        $this->id             = $id;
        $this->specDocSheetId = $specDocSheetId;
        $this->targetArea     = $targetArea;
        $this->checkDetail    = $checkDetail;
        $this->statusId       = $statusId;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSpecDocSheetId(): int
    {
        return $this->specDocSheetId;
    }

    public function getTargetArea(): TargetArea
    {
        return $this->targetArea;
    }

    public function getCheckDetail(): CheckDetail
    {
        return $this->checkDetail;
    }

    public function getRemark(): ?Remark
    {
        return $this->remark;
    }

    public function getStatusId(): StatusId
    {
        return $this->statusId;
    }

    /**
     * Viewに渡すために配列に変換
     *
     * @return array<string, int|null|string>
     */
    public function toArray(): array
    {
        return [
            'id'             => $this->id,
            'specDocSheetId' => $this->specDocSheetId,
            'targetArea'     => $this->targetArea->value(),
            'checkDetail'    => $this->checkDetail->value(),
            'remark'         => $this->remark?->value(),
            'statusId'       => $this->statusId->value(),
        ];
    }
}

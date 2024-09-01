<?php

namespace App\Domain\SpecDocItem;

/**
 * テスト項目 Data Transfer Object
 */
final class SpecDocItemDto
{
    public function __construct(
        public ?int $id,
        public int $specDocSheetId,
        public string $targetArea,
        public string $checkDetail,
        public ?string $remark,
        public int $statusId,
    ) {
        $this->id             = $id;
        $this->specDocSheetId = $specDocSheetId;
        $this->targetArea     = $targetArea;
        $this->checkDetail    = $checkDetail;
        $this->remark         = $remark;
        $this->statusId       = $statusId;
    }
}

<?php

namespace App\Domain\SpecDocSheet;

use DateTimeImmutable;

/**
 * シート(実施環境毎の仕様書)Data Transfer Object(データの受け渡し専用クラス)
 */
final class SpecDocSheetDto
{
    public function __construct(
        public ?int $id,
        public int $specDocId,
        public int $execEnvId,
        public int $statusId,
        public DateTimeImmutable $updatedAt,
        public ?string $execEnvName,
    ) {
        $this->id          = $id;
        $this->specDocId   = $specDocId;
        $this->execEnvId   = $execEnvId;
        $this->statusId    = $statusId;
        $this->updatedAt   = $updatedAt;
        $this->execEnvName = $execEnvName;
    }
}

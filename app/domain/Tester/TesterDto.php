<?php

namespace App\Domain\Tester;

final class TesterDto
{
    public function __construct(
        public ?int $id,
        public ?int $userId,
        public int $specDocSheetId,
        public string $createdAt,
        public ?string $userName = null,
    ) {
        $this->id             = $id;
        $this->userId         = $userId;
        $this->specDocSheetId = $specDocSheetId;
        $this->createdAt      = $createdAt;
        $this->userName       = $userName;
    }
}

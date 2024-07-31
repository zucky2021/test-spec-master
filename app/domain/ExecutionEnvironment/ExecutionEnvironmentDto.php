<?php

namespace App\Domain\ExecutionEnvironment;

/**
 * 実施環境Data Transfer Object(データの受け渡し専用クラス)
 */
final class ExecutionEnvironmentDto
{
    public function __construct(
        public ?int $id,
        public string $name,
        public int $orderNum,
        public bool $isDisplay,
    ) {
        $this->id        = $id;
        $this->name      = $name;
        $this->orderNum  = $orderNum;
        $this->isDisplay = $isDisplay;
    }
}

<?php

namespace App\Domain\ExecutionEnvironment;

use App\Domain\ExecutionEnvironment\ValueObject\Name;
use App\Domain\ExecutionEnvironment\ValueObject\OrderNum;

/**
 * プロジェクトentity
 */
final class ExecutionEnvironmentEntity
{
    public function __construct(
        private ?int $id,
        private Name $name,
        private OrderNum $orderNum,
        private bool $isDisplay,
    ) {
        $this->id        = $id;
        $this->name      = $name;
        $this->orderNum  = $orderNum;
        $this->isDisplay = $isDisplay;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function getOrderNum(): OrderNum
    {
        return $this->orderNum;
    }

    public function getIsDisplay(): bool
    {
        return $this->isDisplay;
    }

    /**
     * Property to array
     *
     * @return array<string, int|null|string|boolean>
     */
    public function toArray(): array
    {
        return [
            'id'        => $this->id,
            'name'      => $this->name->value(),
            'orderNum'  => $this->orderNum->value(),
            'isDisplay' => $this->isDisplay,
        ];
    }
}

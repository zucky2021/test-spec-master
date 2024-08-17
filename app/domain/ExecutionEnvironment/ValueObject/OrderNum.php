<?php

namespace App\Domain\ExecutionEnvironment\ValueObject;

use App\Domain\ValueObjectInterface\IntValue;
use InvalidArgumentException;

/**
 * 並び順VO
 */
final class OrderNum implements IntValue
{
    public function __construct(private int $value)
    {
        $this->validate($this->value);
        $this->value = $value;
    }

    public function validate(int $value): void
    {
        if ($value <= 0) {
            throw new InvalidArgumentException(__CLASS__ . ' must be a natural number.');
        }
    }

    public function value(): int
    {
        return $this->value;
    }
}

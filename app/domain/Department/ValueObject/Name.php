<?php

namespace App\Domain\Department\ValueObject;

use App\Domain\ValueObjectInterface\StringValue;
use InvalidArgumentException;

final class Name implements StringValue
{
    public const MAX_LEN = 100;

    public function __construct(private string $value)
    {
        $this->validate($value);
        $this->value = $value;
    }

    public function validate(string $value): void
    {
        if (mb_strlen($value) > self::MAX_LEN) {
            throw new InvalidArgumentException('The maximum number of characters is ' . self::MAX_LEN);
        }
    }

    public function value(): string
    {
        return $this->value;
    }
}

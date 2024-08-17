<?php

namespace App\Domain\ExecutionEnvironment\ValueObject;

use App\Domain\ValueObjectInterface\StringValue;
use InvalidArgumentException;

/**
 * 実施環境名VO
 */
final class Name implements StringValue
{
    public const MAX_LEN = 100;

    public function __construct(private string $value)
    {
        $this->validate($this->value);
        $this->value = $value;
    }

    public function validate(string $value): void
    {
        if (mb_strlen($value) > self::MAX_LEN) {
            throw new InvalidArgumentException(__CLASS__ . ' must be less than ' . self::MAX_LEN . ' characters.');
        }
    }

    public function value(): string
    {
        return $this->value;
    }
}

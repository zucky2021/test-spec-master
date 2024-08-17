<?php

namespace App\Domain\SpecificationDocument\ValueObject;

use App\Domain\ValueObjectInterface\StringValue;
use InvalidArgumentException;

/**
 * 仕様書概要値オブジェクト
 */
final class Summary implements StringValue
{
    public const MAX_LEN = 1000;
    private string $value;

    public function __construct(string $value)
    {
        $this->validate($this->value);
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

<?php

namespace App\Domain\User\ValueObject;

use App\Domain\ValueObjectInterface\StringValue;
use InvalidArgumentException;

/**
 * ユーザー名値オブジェクト
 */
final class Name implements StringValue
{
    public const MAX_LEN = 255;
    private string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
        $this->validate($this->value);
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

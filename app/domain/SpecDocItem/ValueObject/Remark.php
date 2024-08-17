<?php

namespace App\Domain\SpecDocItem\ValueObject;

use App\Domain\ValueObjectInterface\StringValue;
use InvalidArgumentException;

/**
 * 備考 VO
 */
final class Remark implements StringValue
{
    public const MAX_LEN = 500;

    public function __construct(private string $value)
    {
        $this->validate($this->value);
        $this->value = $value;
    }

    public function validate(string $value): void
    {
        if (mb_strlen($value) > self::MAX_LEN) {
            throw new InvalidArgumentException(
                sprintf(
                    '%s must be less than %d characters, got %d.',
                    __CLASS__,
                    self::MAX_LEN,
                    mb_strlen($value),
                ),
            );
        }
    }

    public function value(): string
    {
        return $this->value;
    }
}

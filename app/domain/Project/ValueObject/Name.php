<?php

namespace App\Domain\Project\ValueObject;

use App\Domain\ValueObjectInterface\StringValue;
use InvalidArgumentException;

/**
 * プロジェクト名VO
 */
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
            throw new InvalidArgumentException(
                sprintf(
                    '%s must be %d or less characters, got %d.',
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

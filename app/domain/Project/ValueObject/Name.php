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

    public function __construct(private string $name)
    {
        $this->name = $name;
        $this->validation($this->name);
    }

    public function validation(string $value): void
    {
        if (mb_strlen($value) > self::MAX_LEN) {
            throw new InvalidArgumentException('The maximum number of characters is ' . self::MAX_LEN);
        }
    }

    public function value(): string
    {
        return $this->name;
    }
}
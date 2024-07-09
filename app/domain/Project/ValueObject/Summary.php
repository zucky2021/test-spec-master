<?php

namespace App\Domain\Project\ValueObject;

use App\Domain\ValueObjectInterface\StringValue;
use InvalidArgumentException;

/**
 * プロジェクト概要VO
 */
final class Summary implements StringValue
{
    public const MAX_LEN = 1000;

    public function __construct(private string $summary)
    {
        $this->summary = $summary;
        $this->validate($this->summary);
    }

    public function validate(string $value): void
    {
        if (mb_strlen($value) > self::MAX_LEN) {
            throw new InvalidArgumentException('The maximum number of characters is ' . self::MAX_LEN);
        }
    }

    public function value(): string
    {
        return $this->summary;
    }
}
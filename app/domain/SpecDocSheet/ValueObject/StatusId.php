<?php

namespace App\Domain\SpecDocSheet\ValueObject;

use App\Domain\ValueObjectInterface\IntValue;
use InvalidArgumentException;

/**
 * Status VO
 */
final class StatusId implements IntValue
{
    public const PENDING     = 0;
    public const IN_PROGRESS = 1;
    public const COMPLETED   = 2;
    public const NG          = 3;

    public const STATUSES = [
        self::PENDING     => 'Pending',
        self::IN_PROGRESS => 'In progress',
        self::COMPLETED   => 'Completed',
        self::NG          => 'NG',
    ];

    public function __construct(private int $value)
    {
        $this->validate($value);
        $this->value = $value;
    }

    public function validate(int $value): void
    {
        if (!array_key_exists($value, self::STATUSES)) {
            throw new InvalidArgumentException(__CLASS__ . ' must be a defined number.');
        }
    }

    public function value(): int
    {
        return $this->value;
    }
}

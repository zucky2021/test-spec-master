<?php

namespace App\Domain\ValueObjectInterface;

/**
 * String type value object interface
 */
interface StringValue
{
    /**
     * Validate the value object property.
     *
     * @param int $value
     * @return void
     */
    public function validate(string $value): void;

    /**
     * Get the property of a value object
     *
     * @return string
     */
    public function value(): string;
}

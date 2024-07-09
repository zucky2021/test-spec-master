<?php

/**
 * Int type value object interface
 */
interface IntValue
{
    /**
     * Validate the value object property.
     *
     * @param int $value
     * @return void
     */
    public function validate(int $value): void;

    /**
     * Get the property of a value object
     *
     * @return int
     */
    public function value(): int;
}

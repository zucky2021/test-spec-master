<?php

namespace App\Domain\ValueObjectInterface;

interface StringValue
{
    public function validation(string $value): void;

    /**
     * Get the value of a value object
     *
     * @return string
     */
    public function value(): string;
}

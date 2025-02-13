<?php

declare(strict_types=1);

namespace App\Shared\Domain;

class Number
{
    public function __construct(protected mixed $value)
    {
        $this->setValue($value);
    }

    public function value(): int
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return (string)$this->value;
    }

    private function setValue(mixed $value): void
    {
        $this->validateIsNumber($value);
        $this->value = $value;
    }

    private function validateIsNumber(mixed $value): void
    {
        if (!is_numeric($value)) {
            throw new InvalidNumber($value);
        }
    }
}

<?php

declare(strict_types=1);

namespace App\Shared\Domain;

class Text
{
    public function __construct(protected mixed $value)
    {
        $this->setValue($value);
    }

    public function value(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return (string)$this->value;
    }

    private function setValue(mixed $value): void
    {
        $this->validateIsString($value);
        $this->value = $value;
    }

    private function validateIsString(mixed $value): void
    {
        if (!is_string($value)) {
            throw new InvalidText($value);
        }
    }
}

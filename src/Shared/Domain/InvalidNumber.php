<?php

declare(strict_types=1);

namespace App\Shared\Domain;

final class InvalidNumber extends \Exception
{
    public function code(): string
    {
        return 'INVALID_NUMBER';
    }

    protected function message(): string
    {
        return 'Value is not a valid number.';
    }
}

<?php

declare(strict_types=1);

namespace App\Shared\Domain;

final class InvalidText extends \Exception
{
    public function code(): string
    {
        return 'INVALID_TEXT';
    }

    protected function message(): string
    {
        return 'Value is not a valid string.';
    }
}

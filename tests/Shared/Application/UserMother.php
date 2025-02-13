<?php

declare(strict_types=1);

namespace App\Tests\Shared\Application;

use App\Shared\Domain\User;

final class UserMother
{
    public static function random(): User
    {
        $i = random_int(0, PHP_INT_MAX);

        return User::fromPrimitives($i);
    }
}

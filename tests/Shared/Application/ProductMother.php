<?php

declare(strict_types=1);

namespace App\Tests\Shared\Application;

use App\Shared\Domain\Product;

final class ProductMother
{
    public static function random(): Product
    {
        $i = random_int(0, PHP_INT_MAX);

        return Product::fromPrimitives($i);
    }
}

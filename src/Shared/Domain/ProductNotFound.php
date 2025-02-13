<?php

declare(strict_types=1);

namespace App\Shared\Domain;

use DomainException;

final class ProductNotFound extends DomainException
{
    public function __construct(readonly private mixed $productId)
    {
        parent::__construct(
            sprintf("Product '%s' not found", $this->productId),
            1
        );
    }
}

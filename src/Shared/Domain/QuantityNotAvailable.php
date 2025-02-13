<?php

declare(strict_types=1);

namespace App\Shared\Domain;

use DomainException;

final class QuantityNotAvailable extends DomainException
{
    public function __construct(
        private readonly mixed $quantity,
        private readonly mixed $productId
    ) {
        parent::__construct(
            sprintf("quantity '%s' not available for product '%s", $this->quantity, $this->productId),
            1
        );
    }
}

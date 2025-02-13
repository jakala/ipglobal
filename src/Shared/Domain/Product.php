<?php

declare(strict_types=1);

namespace App\Shared\Domain;

final class Product
{
    private function __construct(
        public readonly ProductId $id,
        public ProductQuantity $quantity
    ) {
    }

    public static function fromPrimitives(int $id, int $quantity = 0): self
    {
        return new self(
            new ProductId($id),
            new ProductQuantity($quantity)
        );
    }

    public function take(int $amount): void
    {
        if ($this->quantity->value() < $amount) {
            throw new QuantityNotAvailable($amount, $this->id->value());
        }

        $this->quantity = new ProductQuantity($this->quantity->value() - $amount);
    }

    public function replenish(int $amount): void
    {
        $this->quantity = new ProductQuantity($this->quantity->value() + $amount);
    }
}

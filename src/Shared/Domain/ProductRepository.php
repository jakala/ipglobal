<?php

namespace App\Shared\Domain;

interface ProductRepository
{
    public function findById(ProductId $id): ?Product;

    public function save(Product $product): void;
}

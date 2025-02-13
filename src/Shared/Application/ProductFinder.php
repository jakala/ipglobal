<?php

declare(strict_types=1);

namespace App\Shared\Application;

use App\Shared\Domain\Product;
use App\Shared\Domain\ProductId;
use App\Shared\Domain\ProductRepository;

readonly class ProductFinder
{
    public function __construct(private ProductRepository $repository)
    {
    }

    public function __invoke(ProductId $id): ?Product
    {
        return $this->repository->findById($id);
    }
}

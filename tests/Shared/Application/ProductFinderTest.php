<?php

namespace App\Tests\Shared\Application;

use App\Shared\Application\ProductFinder;
use App\Shared\Domain\ProductRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ProductFinderTest extends TestCase
{
    public function testProductExistAndFind(): void
    {
        $product = ProductMother::random();
        $repository = $this->createMock(ProductRepository::class);
        $repository
            ->expects($this->once())
            ->method('findById')
            ->willReturn($product);
        $finder = $this->getProductFinder($repository);

        $response = $finder->__invoke($product->id);

        $this->assertEquals($product, $response);
    }

    private function getProductFinder(ProductRepository|MockObject $repository): ProductFinder
    {
        return new ProductFinder($repository);
    }
}

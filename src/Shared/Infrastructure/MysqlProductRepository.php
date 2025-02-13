<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure;

use App\Shared\Domain\Product;
use App\Shared\Domain\ProductId;
use App\Shared\Domain\ProductRepository;
use App\Shared\Infrastructure\Entity\Product as ProductEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class MysqlProductRepository extends ServiceEntityRepository implements ProductRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductEntity::class);
    }

    public function findById(ProductId $id): ?Product
    {

        $productEntity =  $this
            ->getEntityManager()
            ->getRepository(ProductEntity::class)
            ->findOneBy(['id' => $id->value()]);

        if (null === $productEntity) {
            return null;
        }

        return Product::fromPrimitives(
            $productEntity->getId(),
            $productEntity->getQuantity()
        );
    }

    public function save(Product $product): void
    {
        $productEntity = $this
            ->getEntityManager()
            ->getRepository(ProductEntity::class)
            ->findOneBy(['id' => $product->id->value()]);

        if (null === $productEntity) {
            $productEntity = new ProductEntity();
            $productEntity->setId($product->id->value());
        }

        $productEntity->setQuantity($product->quantity->value());

        $this->getEntityManager()->persist($productEntity);
        $this->getEntityManager()->flush();
    }
}

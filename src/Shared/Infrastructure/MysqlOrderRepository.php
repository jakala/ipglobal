<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure;

use App\Shared\Domain\Order;
use App\Shared\Domain\OrderId;
use App\Shared\Domain\OrderRepository;
use App\Shared\Infrastructure\Entity\Order as OrderEntity;
use App\Shared\Infrastructure\Entity\Product;
use App\Shared\Infrastructure\Entity\Product as ProductEntity;
use App\Shared\Infrastructure\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class MysqlOrderRepository extends ServiceEntityRepository implements OrderRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrderEntity::class);
    }
    public function save(Order $order): void
    {
        $orderEntity = $this->getEntityManager()
            ->getRepository(OrderEntity::class)
            ->findOneBy(['id' => $order->orderId->value()]);

        if (!$orderEntity) {
            $user = $this
                ->getEntityManager()
                ->getRepository(User::class)
                ->findOneBy(['id' => $order->userId->value()]);
            $product = $this
                ->getEntityManager()
                ->getRepository(Product::class)
                ->findOneBy(['id' => $order->productId->value()]);
            $orderEntity = (new OrderEntity())
                ->setId($order->orderId->value())
                ->setUserId($user)
                ->setProductId($product);
        }
        $orderEntity
            ->setAmount($order->amount->value())
            ->setStatus($order->status->value());

        $this->getEntityManager()->persist($orderEntity);
        $this->getEntityManager()->flush();
    }

    public function findById(OrderId $id): ?Order
    {

        $orderEntity = $this
            ->getEntityManager()
            ->getRepository(OrderEntity::class)
            ->findOneBy(['id' => $id->value()]);
        if (null === $orderEntity) {
            return null;
        }
        return Order::fromPrimitives(
            $orderEntity->getId(),
            $orderEntity->getUserId()->getId(),
            $orderEntity->getProductId()->getId(),
            $orderEntity->getAmount(),
            $orderEntity->getStatus(),
            $orderEntity->getNotes()
        );
    }
}

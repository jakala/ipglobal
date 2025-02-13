<?php

namespace App\Tests\Shop\OrderProducer\Application;

use App\Shared\Application\ProductFinder;
use App\Shared\Application\UserFinder;
use App\Shared\Domain\OrderRepository;
use App\Shared\Domain\ProductNotFound;
use App\Shared\Domain\UserNotFound;
use App\Shop\OrderProducer\Application\CreateOrder;
use App\Tests\Shared\Application\ProductMother;
use App\Tests\Shared\Application\UserMother;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;

class CreateOrderTest extends TestCase
{
    /**
     * @doesNotPerformAssertions
     */
    public function testCreateOrderSuccess(): void
    {
        $userFinder = $this->createMock(UserFinder::class);
        $userFinder
            ->method('__invoke')
            ->willReturn(UserMother::random());
        $productFinder = $this->createMock(ProductFinder::class);
        $productFinder
            ->method('__invoke')
            ->willReturn(ProductMother::random());

        $createOrder = $this->getCreateOrder($userFinder, $productFinder);

        $createOrder->__invoke(CreateOrderCommandMother::create(null, null, null, null));
    }

    public function testCreateOrderThrowsUserNotFound(): void
    {
        self::expectException(UserNotFound::class);
        $userFinder = $this->createMock(UserFinder::class);
        $userFinder
            ->method('__invoke')
            ->willReturn(null);

        $productFinder = $this->createMock(ProductFinder::class);

        $createOrder = $this->getCreateOrder($userFinder, $productFinder);

        $createOrder->__invoke(CreateOrderCommandMother::create(null, null, null, null));
    }

    public function testCreateOrderThrowsProductException(): void
    {
        self::expectException(ProductNotFound::class);
        $userFinder = $this->createMock(UserFinder::class);
        $userFinder
            ->method('__invoke')
            ->willReturn(UserMother::random());
        $productFinder = $this->createMock(ProductFinder::class);
        $productFinder
            ->method('__invoke')
            ->willReturn(null);

        $createOrder = $this->getCreateOrder($userFinder, $productFinder);

        $createOrder->__invoke(CreateOrderCommandMother::create(null, null, null, null));
    }

    private function getCreateOrder(UserFinder $userFinder, ProductFinder $productFinder): CreateOrder
    {
        $orderRepository = $this->createMock(OrderRepository::class);
        $bus = $this->createMock(MessageBusInterface::class);
        $envelope = new Envelope(new \stdClass());
        $bus
            ->method('dispatch')
            ->willReturn($envelope);

            return new CreateOrder($userFinder, $productFinder, $orderRepository, $bus);
    }
}

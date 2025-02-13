<?php

declare(strict_types=1);

namespace App\Shop\OrderProducer\Application;

use App\Shared\Application\CreateOrderCommand;
use App\Shared\Application\ProductFinder;
use App\Shared\Application\UserFinder;
use App\Shared\Domain\Order;
use App\Shared\Domain\OrderRepository;
use App\Shared\Domain\ProductId;
use App\Shared\Domain\ProductNotFound;
use App\Shared\Domain\UserId;
use App\Shared\Domain\UserNotFound;
use App\Shop\OrderProducer\Domain\CreateOrderNotification;
use Symfony\Component\Messenger\MessageBusInterface;

readonly final class CreateOrder
{
    public function __construct(
        private UserFinder $userFinder,
        private ProductFinder $productFinder,
        private OrderRepository $orderRepository,
        private MessageBusInterface $bus
    ) {
    }
    public function __invoke(CreateOrderCommand $command): void
    {
        $this->ensureUserExists($command->userId);
        $this->ensureProductExists($command->productId);

        $order = Order::fromPrimitives(
            $command->orderId->value(),
            $command->userId->value(),
            $command->productId->value(),
            $command->amount->value(),
            $command->orderStatus->value(),
            $command->notes->value()
        );
        $this->orderRepository->save($order);
        $message = new CreateOrderNotification($command->orderId);
        $this->bus->dispatch($message);
    }

    private function ensureUserExists(UserId $userId): void
    {
        if ($this->userFinder->__invoke($userId) === null) {
            throw new UserNotFound($userId->value());
        }
    }

    private function ensureProductExists(ProductId $productId): void
    {
        $product = $this->productFinder->__invoke($productId);
        if ($product === null) {
            throw new ProductNotFound($productId->value());
        }
    }
}

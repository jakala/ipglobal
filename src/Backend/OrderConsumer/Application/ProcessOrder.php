<?php

declare(strict_types=1);

namespace App\Backend\OrderConsumer\Application;

use App\Shared\Application\ProductFinder;
use App\Shared\Application\UserFinder;
use App\Shared\Domain\Order;
use App\Shared\Domain\OrderRepository;
use App\Shared\Domain\OrderStatus;
use App\Shared\Domain\Product;
use App\Shared\Domain\ProductId;
use App\Shared\Domain\ProductNotFound;
use App\Shared\Domain\ProductRepository;
use App\Shared\Domain\QuantityNotAvailable;
use App\Shared\Domain\UserId;
use App\Shared\Domain\UserNotFound;
use App\Shop\OrderProducer\Domain\CreateOrderNotification;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]

final class ProcessOrder
{
    public function __construct(
        private UserFinder $userFinder,
        private ProductFinder $productFinder,
        private ProductRepository $productRepository,
        private OrderRepository $orderRepository,
    ) {
    }
    public function __invoke(CreateOrderNotification $orderNotification): void
    {
        $order = $this->orderRepository->findById($orderNotification->order);
        $notes = null;
        try {
            $this->ensureUserExists($order->userId);
            $product = $this->getProduct($order->productId);

            $product->take($order->amount->value());
            $this->productRepository->save($product);
            $order->approve();
            print_r(sprintf('order: "%d" %s' . PHP_EOL,
                $orderNotification->order->value(),
                OrderStatus::APPROVED));

        } catch (ProductNotFound | UserNotFound | QuantityNotAvailable $e) {
            print_r(sprintf('order: "%d" %s' . PHP_EOL, $orderNotification->order->value(), $e->getMessage()));
            $notes = $e->getMessage();
            $order->reject();
        } finally {
            $order = Order::fromPrimitives(
                $order->orderId->value(),
                $order->userId->value(),
                $order->productId->value(),
                $order->amount->value(),
                $order->status->value(),
                $notes
            );
            $this->orderRepository->save($order);
        }
    }

    private function ensureUserExists(UserId $userId): void
    {
        $this->simulateTimeProcess();
        if ($this->userFinder->__invoke($userId) === null) {
            throw new UserNotFound($userId->value());
        }
    }

    private function getProduct(ProductId $productId): Product
    {
        $this->simulateTimeProcess();
        $product = $this->productFinder->__invoke($productId);
        if ($product === null) {
            throw new ProductNotFound($productId->value());
        }

        return $product;
    }

    private function simulateTimeProcess(): void
    {
        $time = random_int(0, 2);
        sleep($time);
    }
}

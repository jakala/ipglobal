<?php

declare(strict_types=1);

namespace App\Shared\Application;

use App\Shared\Domain\Amount;
use App\Shared\Domain\OrderId;
use App\Shared\Domain\OrderNotes;
use App\Shared\Domain\OrderStatus;
use App\Shared\Domain\ProductId;
use App\Shared\Domain\UserId;

readonly final class CreateOrderCommand
{
    private function __construct(
        public OrderId $orderId,
        public UserId $userId,
        public ProductId $productId,
        public Amount $amount,
        public OrderStatus $orderStatus,
        public OrderNotes $notes
    ) {
    }

    public static function fromPrimitives(
        int $orderId,
        int $userId,
        int $productId,
        int $amount,
        string $orderStatus,
        string $notes
    ): self {
        return new self(
            new OrderId($orderId),
            new UserId($userId),
            new ProductId($productId),
            new Amount($amount),
            new OrderStatus($orderStatus),
            new OrderNotes($notes)
        );
    }
}

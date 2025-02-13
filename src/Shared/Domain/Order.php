<?php

declare(strict_types=1);

namespace App\Shared\Domain;

final class Order
{
    private function __construct(
        readonly public OrderId $orderId,
        readonly UserId $userId,
        readonly ProductId $productId,
        readonly Amount $amount,
        public OrderStatus $status,
        readonly ?OrderNotes $notes
    ) {
    }

    public static function fromPrimitives(
        int $orderId,
        int $userId,
        int $productId,
        int $amount,
        string $status,
        ?string $notes = ''
    ): self {
        return new self(
            new OrderId($orderId),
            new UserId($userId),
            new ProductId($productId),
            new Amount($amount),
            new OrderStatus($status),
            $notes ? new OrderNotes($notes) : null
        );
    }

    public function approve(): void
    {
        $this->status = new OrderStatus('APPROVED');
    }

    public function reject(): void
    {
        $this->status = new OrderStatus('REJECTED');
    }

    public function pending(): void
    {
        $this->status = new OrderStatus('PENDING');
    }
}

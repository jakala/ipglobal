<?php

declare(strict_types=1);

namespace App\Tests\Shop\OrderProducer\Application;

use App\Shared\Application\CreateOrderCommand;
use App\Shared\Domain\OrderStatus;

final class CreateOrderCommandMother
{
    public static function random(): CreateOrderCommand
    {
        $i = random_int(0, PHP_INT_MAX);
        return createOrderCommand::fromPrimitives(
            $i,
            $i,
            $i,
            $i,
            OrderStatus::APPROVED,
            'order_status_' . $i,
        );
    }
    public static function create(
        ?int $orderId,
        ?int $userId,
        ?int $productId,
        ?int $amount
    ): CreateOrderCommand {
        $i = random_int(0, PHP_INT_MAX);
        return createOrderCommand::fromPrimitives(
            $orderId ?? $i,
            $userId ??  $i,
            $productId ??  $i,
            $amount ?? $i,
            OrderStatus::APPROVED,
            'order_status_' . $i,
        );
    }
}

<?php

declare(strict_types=1);

namespace App\Shop\OrderProducer\Domain;

use App\Shared\Domain\OrderId;
use Symfony\Component\Messenger\Attribute\AsMessage;

#[AsMessage('async')]
final readonly class CreateOrderNotification
{
    public function __construct(public OrderId $order)
    {
    }
}

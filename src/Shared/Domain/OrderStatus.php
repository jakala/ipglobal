<?php

declare(strict_types=1);

namespace App\Shared\Domain;

final class OrderStatus extends Text
{
    public const APPROVED = 'APPROVED';
    public const REJECTED = 'REJECTED';
    public const PENDING = 'PENDING';
}

<?php

namespace App\Shared\Domain;

interface OrderRepository
{
    public function save(Order $order): void;

    public function findById(OrderId $id): ?Order;
}

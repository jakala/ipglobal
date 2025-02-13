<?php

declare(strict_types=1);

namespace App\Shared\Domain;

final class User
{
    private function __construct(
        public UserId $id
    ) {
    }

    public static function fromPrimitives(?int $id): self
    {
        return new self(
            new UserId($id)
        );
    }
}

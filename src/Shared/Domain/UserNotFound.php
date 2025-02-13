<?php

declare(strict_types=1);

namespace App\Shared\Domain;

use DomainException;

final class UserNotFound extends DomainException
{
    public function __construct(readonly private mixed $userId)
    {
        parent::__construct(
            sprintf("User '%s' not found", $this->userId),
            1
        );
    }
}

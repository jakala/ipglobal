<?php

declare(strict_types=1);

namespace App\Shared\Application;

use App\Shared\Domain\User;
use App\Shared\Domain\UserId;
use App\Shared\Domain\UserRepository;

readonly class UserFinder
{
    public function __construct(private UserRepository $userRepository)
    {
    }

    public function __invoke(UserId $id): ?User
    {
        return $this->userRepository->findById($id);
    }
}

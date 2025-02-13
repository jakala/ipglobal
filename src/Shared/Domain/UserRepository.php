<?php

namespace App\Shared\Domain;

interface UserRepository
{
    public function findById(UserId $id): ?User;
}

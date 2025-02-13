<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure;

use App\Shared\Domain\User;
use App\Shared\Domain\UserId;
use App\Shared\Domain\UserRepository;
use App\Shared\Infrastructure\Entity\User as UserEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class MysqlUserRepository extends ServiceEntityRepository implements UserRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserEntity::class);
    }
    public function findById(UserId $id): ?User
    {
        /** @var UserEntity $user */
        $user = $this->findOneBy(['id' => $id->value()]);
        if (!$user) {
            return null;
        }

        return User::fromPrimitives($user->getId());
    }
}

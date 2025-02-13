<?php

namespace App\Shared\Infrastructure\Entity;

use App\Shared\Infrastructure\MysqlUserRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MysqlUserRepository::class)]
#[ORM\Table(name: '`user`')]

class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 32)]
    private ?string $name = null;

    public function getId(): ?int
    {
        return $this->id;
    }
}

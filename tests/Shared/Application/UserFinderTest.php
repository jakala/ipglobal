<?php

namespace App\Tests\Shared\Application;

use App\Shared\Application\ProductFinder;
use App\Shared\Application\UserFinder;
use App\Shared\Domain\UserRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class UserFinderTest extends TestCase
{
    public function testUserExistAndFind(): void
    {
        $user = UserMother::random();
        $repository = $this->createMock(UserRepository::class);
        $repository
            ->expects($this->once())
            ->method('findById')
            ->willReturn($user);
        $finder = $this->getUserFinder($repository);

        $response = $finder->__invoke($user->id);

        $this->assertEquals($user, $response);
    }

    private function getUserFinder(UserRepository|MockObject $repository): UserFinder
    {
        return new UserFinder($repository);
    }
}

<?php

namespace App\Tests\Entity;

use App\Entity\Task;
use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testIsTrue()
    {
        $user = new User();

        $user->setUsername('Username')
            ->setPassword('password')
            ->setEmail('email@gmail.com')
            ->setRoles(['ROLE_ADMIN']);

        $this->assertTrue($user->getUsername() === 'Username');
        $this->assertTrue($user->getUserIdentifier() === 'Username');
        $this->assertTrue($user->getPassword() === 'password');
        $this->assertTrue($user->getEmail() === 'email@gmail.com');
        $this->assertTrue($user->getRoles() === ['ROLE_ADMIN', 'ROLE_USER']);

    }

    public function testIsFalse()
    {
        $user = new User();

        $user->setUsername('Username')
            ->setPassword('password')
            ->setEmail('email@gmail.com')
            ->setRoles(['ROLE_ADMIN']);

        $this->assertFalse($user->getUserIdentifier() === 'false');
        $this->assertFalse($user->getPassword() === 'false');
        $this->assertFalse($user->getEmail() === 'false');
        $this->assertFalse($user->getRoles() === ['false']); 

        $user->getSalt();
    }

    public function testIsEmpty()
    {
        $user = new User();
        $user->setPassword('');

        $this->assertEmpty($user->getUserIdentifier());
        $this->assertEmpty($user->getPassword());
        $this->assertEmpty($user->getEmail());
        $this->assertEmpty($user->getTasks());
        $this->assertEmpty($user->getId());
    }

    public function testAddRemoveTask(){
        $user = new User();
        $task = new Task();

        $this->assertEmpty($user->getTasks());

        $user->addTask($task);
        $this->assertContains($task, $user->getTasks());

        $user->removeTask($task);
        $this->assertEmpty($user->getTasks());
    }
}

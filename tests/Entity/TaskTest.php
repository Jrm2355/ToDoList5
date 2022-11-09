<?php

namespace App\Tests\Entity;

use App\Entity\Task;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class TaskTest extends TestCase
{
    public function testIsTrue()
    {
        $task = new Task();
        $datetime = new \DateTimeImmutable();
        $user = new User();

        $task->setTitle('Titre')
                ->setCreatedAt($datetime)
                ->setContent('Contenu')
                ->setUser($user);

        $this->assertTrue($task->getTitle() === 'Titre');
        $this->assertTrue($task->getCreatedAt() === $datetime);
        $this->assertTrue($task->getContent() === 'Contenu');
        $this->assertTrue($task->getUser() === $user);
    }

    public function testIsFalse()
    {
        $task = new Task();
        $datetime = new \DateTimeImmutable();
        $user = new User();

        $task->setTitle('Titre')
                ->setCreatedAt($datetime)
                ->setContent('Contenu');

        $this->assertFalse($task->getTitle() === 'false');
        $this->assertFalse($task->getCreatedAt() === new \DateTimeImmutable());
        $this->assertFalse($task->getContent() === 'false');
        $this->assertFalse($task->getUser() === 'false');
    }
    
    public function testIsEmpty()
    {
        $task = new Task();

        $this->assertEmpty($task->getTitle());
        $this->assertEmpty($task->getCreatedAt());
        $this->assertEmpty($task->getContent());
        $this->assertEmpty($task->getUser());
    }
}

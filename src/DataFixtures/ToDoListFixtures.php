<?php

namespace App\DataFixtures;

use App\Entity\Task;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;


class ToDoListFixtures extends Fixture
{
    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $users = [
            [
                "username"=>"Jyon",
                "password"=>"jyon",
                "email"=>"jyon@gmail.com",
                "roles"=>['ROLE_ADMIN'],
                "tasks"=>[
                    [
                        "title"=>"Tâche de l'admin Jyon",
                        "content"=>"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam vitae malesuada lorem. Donec rutrum vulputate felis, vel lobortis mi vulputate in. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Phasellus vitae dapibus massa. Nunc vel suscipit metus. Sed id lacus quam. Duis elementum porttitor tellus vitae pellentesque.",
                    ],
                    [
                        "title"=>"Seconde Tâche de l'admin Jyon",
                        "content"=>"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam vitae malesuada lorem. Donec rutrum vulputate felis, vel lobortis mi vulputate in. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Phasellus vitae dapibus massa. Nunc vel suscipit metus. Sed id lacus quam. Duis elementum porttitor tellus vitae pellentesque.",
                    ],
                ],
            ],
            [
                "username"=>"User",
                "password"=>"123",
                "email"=>"user@gmail.com",
                "roles"=>[],
                "tasks"=>[
                    [
                        "title"=>"Tâche d'User",
                        "content"=>"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam vitae malesuada lorem. Donec rutrum vulputate felis, vel lobortis mi vulputate in. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Phasellus vitae dapibus massa. Nunc vel suscipit metus. Sed id lacus quam. Duis elementum porttitor tellus vitae pellentesque.",
                    ],
                    [
                        "title"=>"Seconde Tâche d'user",
                        "content"=>"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam vitae malesuada lorem. Donec rutrum vulputate felis, vel lobortis mi vulputate in. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Phasellus vitae dapibus massa. Nunc vel suscipit metus. Sed id lacus quam. Duis elementum porttitor tellus vitae pellentesque.",
                    ],
                ],
            ],
        ];

        foreach ($users as $u) {
            $user = new User();
            $user->setUsername($u["username"]);
            $user->setPassword(
                $this->passwordHasher->hashPassword(
                    $user,
                    $u["password"] ));
            $user->setRoles($u["roles"]);
            $user->setEmail($u["email"]);
            $manager->persist($user);

            foreach($u["tasks"] as $t){
                $task = new Task();
                $task->setTitle($t["title"]);
                $task->setContent($t["content"]);
                $task->setCreatedAt(new \DateTimeImmutable());
                $task->setIsDone(false);
                $task->setUser(null);
                $manager->persist($task);
            }
        }
        $manager->flush();
    }
}
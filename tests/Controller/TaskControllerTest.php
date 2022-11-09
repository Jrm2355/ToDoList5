<?php

// namespace App\Tests\Controller;

// use App\Entity\Task;
// use Symfony\Component\HttpFoundation\Request;
// use Symfony\Component\HttpFoundation\Response;
// use Symfony\Bundle\FrameworkBundle\KernelBrowser;
// use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

// class TaskControllerTest extends WebTestCase
// {
//     private KernelBrowser|null $client = null;

//     public function setUp() : void
//     {
//         $this->client = static::createClient();
//     }

//     public function testTaskListIsUp()
//     {
//         $taskRepository = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(Task::class);
//         $testTasks = $taskRepository->findAll();

//         $urlGenerator = $this->client->getContainer()->get('router.default');
//         $this->client->request(Request::METHOD_GET, $urlGenerator->generate('task_list'));
//         $this->assertResponseStatusCodeSame(Response::HTTP_OK);
//     }
// }
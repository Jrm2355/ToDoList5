<?php

namespace App\Tests\Controller;

use App\Entity\Task;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{
    public function testLoginPage(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');

        $this->assertResponseIsSuccessful();
    }

    public function testVisitingWithLogin(): void
    {
        //Login Test
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');

        $buttonCrawlerNode = $crawler->selectButton('Se connecter');
        $form = $buttonCrawlerNode->form();

        $form = $buttonCrawlerNode->form([
            '_username' => 'Jyon',
            '_password' => 'jyon',
        ]);

        $client->submit($form);
        $client->followRedirect();
        
        // Users Route et edit User
        $crawler = $client->request('GET', '/users');
        $this->assertResponseIsSuccessful();

        // delete admin task
        $taskRepository = $client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(Task::class);
        $task = $taskRepository->findOneBy(array('title' => 'titre edit'));
        $taskId = $task->getId();
        $crawler = $client->request('GET', '/tasks/'.$taskId.'/delete');
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
    }
}

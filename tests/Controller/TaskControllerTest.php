<?php

namespace App\Tests\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DomCrawler\Test\Constraint\CrawlerSelectorAttributeValueSame;

class TaskControllerTest extends WebTestCase
{
    private KernelBrowser|null $client = null;

    public function setUp() : void
    {
        $this->client = static::createClient();
        $this->urlGenerator = $this->client->getContainer()->get('router.default');
        
    }

    public function testTaskListIsUp()
    {
        $this->client->request(Request::METHOD_GET, $this->urlGenerator->generate('task_list'));
        $this->assertResponseIsSuccessful();
    }

    public function testTaskCreate()
    {
        $crawler = $this->client->request(Request::METHOD_GET, $this->urlGenerator->generate('task_create'));

        $form = $crawler->selectButton('Ajouter')->form();
        $form['task[title]'] = 'titre test';
        $form['task[content]'] = 'contenu du todo';
        $this->client->submit($form);
        $this->client->followRedirect();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testTaskEdit()
    {
        $crawler = $this->client->request(Request::METHOD_GET, $this->urlGenerator->generate('task_list'));
        $link = $crawler->selectLink('titre test')->link();
        $crawler = $this->client->click($link);

        $form = $crawler->selectButton('Modifier')->form();
        $form['task[title]'] = 'titre edit';
        $form['task[content]'] = 'contenu du todo edit';
        $this->client->submit($form);
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        $this->client->followRedirect();
    }

    public function testTaskToggle()
    {
        $crawler = $this->client->request('GET', '/tasks');

        $button = $crawler->selectButton('Marquer')->form();
        $this->client->submit($button);
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
    }
}

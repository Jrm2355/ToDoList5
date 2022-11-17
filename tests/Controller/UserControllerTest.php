<?php

namespace App\Tests\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    private KernelBrowser|null $client = null;

    public function setUp(): void
    {
        $this->client = static::createClient();
        $this->urlGenerator = $this->client->getContainer()->get('router.default');
    }

    public function testUserCreate() : void
    {
        $crawler = $this->client->request(Request::METHOD_GET, $this->urlGenerator->generate('user_create'));

        $form = $crawler->selectButton('Ajouter')->form();
        $form['user[username]'] = 'test';
        $form['user[password][first]'] = 'mdp';
        $form['user[password][second]'] = 'mdp';
        $form['user[email]'] = 'test@g.com';
        $this->client->submit($form);
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        $this->client->followRedirect();

        $userRepository = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(User::class);
        $user = $userRepository->findOneBy(array('username' => 'test'));
        $userRepository->remove($user, true);
    }
}

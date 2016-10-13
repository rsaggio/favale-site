<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BlogControllerTest extends WebTestCase
{
    public function testLista()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/blog');
    }

    public function testDetalhe()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/post');
    }

    public function testBusca()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/busca');
    }

}

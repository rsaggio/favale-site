<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SiteControllerTest extends WebTestCase
{
    public function testHome()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');
    }

    public function testParceiros()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/parceiros');
    }

    public function testContato()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/contato');
    }

}

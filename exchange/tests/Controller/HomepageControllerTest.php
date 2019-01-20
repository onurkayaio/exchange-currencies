<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomepageControllerTest extends WebTestCase
{
    public function testHomePageController()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertEquals(1, $crawler->filter('html:contains("providerOne")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("providerTwo")')->count());

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
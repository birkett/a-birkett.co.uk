<?php

namespace WebsiteBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GenericControllerTest extends WebTestCase
{
    public function testGenericPages()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/about/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('About Anthony', $crawler->filter('.post h2')->text());
    }
}

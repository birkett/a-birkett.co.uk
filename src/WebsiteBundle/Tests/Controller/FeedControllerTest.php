<?php

namespace WebsiteBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FeedControllerTest extends WebTestCase
{
    public function testFeed()
    {
        $client = static::createClient();

        $client->request('GET', '/feed/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('text/xml; charset=UTF-8', $client->getResponse()->headers->get('Content-Type'));
    }
}

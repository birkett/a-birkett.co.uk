<?php

namespace WebsiteBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BlogControllerTest extends WebTestCase
{
    public function testBlog()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/blog/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Anthony Birkett', $crawler->filter('#container h1')->text());
    }
}

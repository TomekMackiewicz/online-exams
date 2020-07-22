<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TestControllerTest extends WebTestCase
{
    public function testApiWorks()
    {
        $client = static::createClient();
        $client->request('GET', '/api/v1/test');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
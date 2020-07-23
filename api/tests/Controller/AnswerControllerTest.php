<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use App\Tests\InitWebTestCase;
use App\DataFixtures\AnswerFixtures;

class AnswerControllerTest extends InitWebTestCase
{
    protected function setUp()
    {
        parent::setUp();
    }

    protected function tearDown(): void
    {
        parent::tearDown();        
    }

    public function testGetAnswer()
    {
        $this->addFixture(AnswerFixtures::class);
        $this->client->request('GET', '/api/v1/answer/1');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testGetAnswers()
    {
        $this->client->request('POST', '/api/v1/answer', [
            'title' => 'Example title',
            'isCorrect' => true,
            'message' => 'Example message',
            'points' => 1 
        ]);
        $this->client->request('GET', '/api/v1/answer');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testPostAnswer()
    {
        $this->client->request('POST', '/api/v1/answer', [
            'title' => 'Example title',
            'isCorrect' => true,
            'message' => 'Example message',
            'points' => 1 
        ]);

        $this->assertEquals(201, $this->client->getResponse()->getStatusCode());
    }

//    public function testPatchAnswer()
//    {
//        $client = static::createClient();
//        $client->request('PATCH', '/api/v1/answer/1');
//
//        $this->assertEquals(200, $client->getResponse()->getStatusCode());
//    }

//    public function testDeleteAnswer()
//    {
//        //$client = static::createClient();
//        $this->client->request('DELETE', '/api/v1/answer/1');
//
//        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
//    }
}

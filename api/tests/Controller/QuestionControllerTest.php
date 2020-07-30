<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use App\Tests\InitWebTestCase;
use App\DataFixtures\QuestionFixture;

class QuestionControllerTest extends InitWebTestCase
{
    protected function setUp()
    {
        parent::setUp();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    public function testGetQuestion()
    {
        $this->addFixture(QuestionFixture::class);
        $this->client->request('GET', '/api/v1/question/1');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testGetQuestions()
    {
        $this->addFixture(QuestionFixture::class);
        $this->client->request('GET', '/api/v1/question');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testPostQuestion()
    {
        $this->client->request('POST', '/api/v1/question', [
            'label' => 'Example label',
            'description' => 'Example description',
            'type' => 'radio',
            'hint' => 'Example hint',
            'is_required' => true,
            'shuffle_answers' => false
        ]);

        $this->assertEquals(201, $this->client->getResponse()->getStatusCode());
    }

    public function testPatchQuestion()
    {
        $this->addFixture(QuestionFixture::class);
        $this->client->request('PATCH', '/api/v1/question/1', [
            'label' => 'New label'
        ]);

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testDeleteQuestion()
    {
        $this->addFixture(QuestionFixture::class);
        $this->client->request('DELETE', '/api/v1/question/1');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }
}

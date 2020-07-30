<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use App\Tests\InitWebTestCase;
use App\DataFixtures\SurveyFixture;

class SurveyControllerTest extends InitWebTestCase
{
    protected function setUp()
    {
        parent::setUp();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    public function testGetSurvey()
    {
        $this->addFixture(SurveyFixture::class);
        $this->client->request('GET', '/api/v1/survey/1');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testGetSurveys()
    {
        $this->addFixture(SurveyFixture::class);
        $this->client->request('GET', '/api/v1/survey');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testPostSurvey()
    {
        $this->client->request('POST', '/api/v1/survey', [
            'title' => 'Example title',
            'description' => 'Example description',
            'summary' => 'Example summary',
            'duration' => 3600,
            'next_submission_after' => 3600,
            'ttl' => 3600,
            'use_pagination' => true,
            'questions_per_page' => 10,
            'shuffle_questions' => false,
            'immediate_answers' => false,
            'restrict_submissions' => false,
            'allowed_submissions' => 1
        ]);

        $this->assertEquals(201, $this->client->getResponse()->getStatusCode());
    }

    public function testPatchSurvey()
    {
        $this->addFixture(SurveyFixture::class);
        $this->client->request('PATCH', '/api/v1/survey/1', [
            'title' => 'New title'
        ]);

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testDeleteSurvey()
    {
        $this->addFixture(SurveyFixture::class);
        $this->client->request('DELETE', '/api/v1/survey/1');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }
}

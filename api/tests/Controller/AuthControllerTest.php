<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use App\Tests\InitWebTestCase;
use App\DataFixtures\UserFixture;

class AuthControllerTest extends InitWebTestCase
{
    protected function setUp()
    {
        parent::setUp();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    public function testRegister()
    {
        $this->client->request('POST', '/api/v1/register', [
            'username' => 'test_user',
            'password' => 'test',
            'email' => 'test@gmail.com'
        ]);

        $this->assertEquals(201, $this->client->getResponse()->getStatusCode());
    }

    public function testLogin()
    {
        $this->addUserFixture(UserFixture::class);
        $this->client->request('POST', '/api/v1/login_check', [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            json_encode(['username' => 'test_user',
            'password' => 'test'])
        ]);

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

}

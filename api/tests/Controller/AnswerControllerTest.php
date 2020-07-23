<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use App\Entity\Answer;

class AnswerControllerTest extends WebTestCase
{
    protected function setUp()
    {
        $this->client = static::createClient();

        if ('test' !== self::$kernel->getEnvironment()) {
            throw new \LogicException('Tests cases with fresh database must be executed in the test environment');
        }

        $kernel = self::bootKernel();
        $this->entityManager = $kernel->getContainer()->get('doctrine')->getManager();
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $purger = new ORMPurger($this->entityManager);
        // Purger mode 2 truncates, resetting autoincrements
        $purger->setPurgeMode(2);
        $purger->purge();
        $this->entityManager->close();
        $this->entityManager = null;        
    }

    public function testGetAnswer()
    {
        $answer = new Answer();
        $answer->setTitle('Yes');
        $answer->setIsCorrect(true);
        $answer->setMessage('Ok, I guess you are right');
        $answer->setPoints(1);
        $this->entityManager->persist($answer);
        $this->entityManager->flush();
        $id = $answer->getId();
       
        $this->client->request('GET', '/api/v1/answer/'.$id);
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

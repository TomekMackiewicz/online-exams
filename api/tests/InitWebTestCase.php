<?php

declare(strict_types=1);

namespace App\Tests;

use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemaTool;
use Metadata\ClassMetadata;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\PlaintextPasswordEncoder;
use App\Entity\User;

class InitWebTestCase extends WebTestCase
{
    /**
     * @var KernelBrowser
     */
    protected $client;

    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var SchemaTool
     */
    protected $schemaTool;

    /**
     * @var ClassMetadata[]
     */
    protected $metaData;

    protected function setUp()
    {
        $this->client = static::createClient();

        if ('test' !== self::$kernel->getEnvironment()) {
            throw new \LogicException('Tests cases with fresh database must be executed in the test environment');
        }

        $kernel = self::bootKernel();
        $this->entityManager = $kernel->getContainer()->get('doctrine')->getManager();
        $this->metaData = $this->entityManager->getMetadataFactory()->getAllMetadata();
        $this->schemaTool = new SchemaTool($this->entityManager);
        $this->schemaTool->updateSchema($this->metaData);
    }

    public function addFixture($className)
    {
        $loader = new Loader();
        $loader->addFixture(new $className);
        $purger = new ORMPurger($this->entityManager);
        $executor = new ORMExecutor($this->entityManager, $purger);
        $executor->execute($loader->getFixtures());
    }

    public function addUserFixture($className)
    {
        $loader = new Loader();
        $defaultEncoder = new PlaintextPasswordEncoder();
        $encoderFactory = new EncoderFactory([User::class => $defaultEncoder]);
        $encoder = new UserPasswordEncoder($encoderFactory);
        $loader->addFixture(new $className($encoder));
        $purger = new ORMPurger($this->entityManager);
        $executor = new ORMExecutor($this->entityManager, $purger);
        $executor->execute($loader->getFixtures());
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        // Hacky, but works (see: https://github.com/doctrine/data-fixtures/pull/127)
        $conn = $this->entityManager->getConnection();
        $sql = "SET foreign_key_checks = 0;";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $purger = new ORMPurger($this->entityManager);
        // Purger mode 2 truncates, resetting autoincrements
        $purger->setPurgeMode(2);
        $purger->purge();
        $this->entityManager->close();
        $this->entityManager = null;
    }
}
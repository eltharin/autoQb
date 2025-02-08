<?php

namespace EltharinAutoQBTests;

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Doctrine\ORM\Tools\SchemaTool;
use EltharinAutoQBTests\Entity\Article;
use EltharinAutoQBTests\Entity\Category;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Cache\Adapter\ArrayAdapter;

class AbstractTestCase extends TestCase
{
    protected EntityManager $entityManager;

    protected Configuration $configuration;

    public function setUp(): void
    {
        $this->configuration = ORMSetup::createAttributeMetadataConfiguration([__DIR__ . '/Entity'], true);

        $this->configuration->setMetadataCache(new ArrayAdapter());
        $this->configuration->setQueryCache(new ArrayAdapter());
        $this->configuration->setProxyDir(__DIR__ . '/Proxies');
        $this->configuration->setAutoGenerateProxyClasses(true);

        $this->entityManager = new EntityManager(
            DriverManager::getConnection(['driver' => 'pdo_sqlite', 'memory' => true], $this->configuration),
            $this->configuration
        );

        $this->schemaTool = new SchemaTool($this->entityManager);
        $this->schemaTool->dropDatabase();
        $this->schemaTool->createSchema([
                                            $this->entityManager->getClassMetadata(Category::class),
                                            $this->entityManager->getClassMetadata(Article::class),
                                        ]);

    }
}
<?php

namespace EltharinAutoQBTests\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Eltharin\AutoQbBundle\DataCollector\AutoQbCollector;
use Eltharin\AutoQbBundle\Objects\DqlOptions;
use Eltharin\AutoQbBundle\Service\QueryBuilderMaker;
use EltharinAutoQBTests\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Eltharin\AutoQbBundle\Repository\AutoQbRepository;

class CommonRepository extends EntityRepository
{
    use AutoQbRepository;
/*
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }
*/
    public function testnoJoins() : QueryBuilder
    {
        $this->myAlias = $this->getClassMetadata()->getTableName();
        $qb = $this->createQueryBuilder($this->myAlias);

        return $qb;
    }
}

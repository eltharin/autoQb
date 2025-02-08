<?php

namespace EltharinAutoQBTests\Repository;

use Doctrine\ORM\EntityRepository;
use EltharinAutoQBTests\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Eltharin\AutoQbBundle\Repository\AutoQbRepository;

class ArticleRepository extends EntityRepository
{
    use AutoQbRepository;
/*
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }
*/
    public function testnoJoins()
    {
        return $this->getDQL();
    }
}

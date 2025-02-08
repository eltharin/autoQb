<?php

namespace EltharinAutoQBTests\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Eltharin\AutoQbBundle\Repository\AutoQbRepository;
use EltharinAutoQBTests\Entity\Article;

class CategoryRepository extends EntityRepository
{
    use AutoQbRepository;

    /*public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }*/

    public function testnoJoins()
    {
        return $this->getDQL();
    }
}
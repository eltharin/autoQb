<?php

namespace EltharinAutoQBTests\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\AssociationMapping;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\QueryBuilder;
use Eltharin\AutoQbBundle\Attributes\AutoQbField;
use Eltharin\AutoQbBundle\Repository\AutoQbRepository;

class Class8Repository extends EntityRepository
{
    use AutoQbRepository;

    public function __construct(
        EntityManagerInterface $em,
        ClassMetadata $class,
    ) {
        parent::__construct($em, $class);
        $this->autoQbAlias = 'mySuperAlias8';
    }

    public function myCallbackInRepository(QueryBuilder $qb, AssociationMapping $assoc, AutoQbField $propertyAttribute, string $alias, string $subAlias, string $separator, $from = [], $count = 0, ?array $with = [])
    {
        $qb->andWhere($alias . '.property = :something')->setParameter('something', 'something');
    }
}

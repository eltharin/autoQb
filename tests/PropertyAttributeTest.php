<?php

namespace EltharinAutoQBTests;

use Eltharin\AutoQbBundle\Objects\DqlOptions;
use EltharinAutoQBTests\Entity\Article;
use EltharinAutoQBTests\Entity\Category;
use EltharinAutoQBTests\Entity\ClassTest1;
use EltharinAutoQBTests\Entity\ClassTest6;
use EltharinAutoQBTests\Entity\ClassTest7;
use EltharinAutoQBTests\Entity\ClassTest8;

class PropertyAttributeTest extends AbstractTestCase
{
    public function testPropertyAttributeAllways1deepth()
    {
        $dql = $this->entityManager->getRepository(ClassTest6::class)->getDQL((new DqlOptions));

        $this->assertCount(1, $dql->getDQLPart('from'));
        $this->assertEquals(ClassTest6::class, $dql->getDQLPart('from')[0]->getFrom());
        $this->assertEquals('classtest6', $dql->getDQLPart('from')[0]->getAlias());

        $this->assertCount(1, $dql->getDQLPart('join'));
        $this->assertCount(1, $dql->getDQLPart('join')['classtest6']);

        $this->assertEquals('classtest6.classtest4', $dql->getDQLPart('join')['classtest6'][0]->getJoin());
        $this->assertEquals('classtest6__classtest4', $dql->getDQLPart('join')['classtest6'][0]->getAlias());
        $this->assertEquals('LEFT', $dql->getDQLPart('join')['classtest6'][0]->getJoinType());
    }

    public function testPropertyAttributeAllways2deepth()
    {
        $dql = $this->entityManager->getRepository(ClassTest1::class)->getDQL((new DqlOptions)->with('classtest1__classtest6'));

        $this->assertCount(1, $dql->getDQLPart('from'));
        $this->assertEquals(ClassTest1::class, $dql->getDQLPart('from')[0]->getFrom());
        $this->assertEquals('classtest1', $dql->getDQLPart('from')[0]->getAlias());

        $this->assertCount(1, $dql->getDQLPart('join'));
        $this->assertCount(2, $dql->getDQLPart('join')['classtest1']);

        $this->assertEquals('classtest1.classtest6', $dql->getDQLPart('join')['classtest1'][0]->getJoin());
        $this->assertEquals('classtest1__classtest6', $dql->getDQLPart('join')['classtest1'][0]->getAlias());
        $this->assertEquals('LEFT', $dql->getDQLPart('join')['classtest1'][0]->getJoinType());

        $this->assertNull($dql->getDQLPart('join')['classtest1'][0]->getConditionType());
        $this->assertNull($dql->getDQLPart('join')['classtest1'][0]->getCondition());

        $this->assertEquals('classtest1__classtest6.classtest4', $dql->getDQLPart('join')['classtest1'][1]->getJoin());
        $this->assertEquals('classtest1__classtest6__classtest4', $dql->getDQLPart('join')['classtest1'][1]->getAlias());
        $this->assertEquals('LEFT', $dql->getDQLPart('join')['classtest1'][1]->getJoinType());

        $this->assertNull($dql->getDQLPart('join')['classtest1'][1]->getConditionType());
        $this->assertNull($dql->getDQLPart('join')['classtest1'][1]->getCondition());
    }

    public function testPropertyAttributeWithAlias()
    {
        $dql = $this->entityManager->getRepository(ClassTest1::class)->getDQL((new DqlOptions)->with('classtest1__class7actif'));

        $this->assertCount(1, $dql->getDQLPart('from'));
        $this->assertEquals(ClassTest1::class, $dql->getDQLPart('from')[0]->getFrom());
        $this->assertEquals('classtest1', $dql->getDQLPart('from')[0]->getAlias());

        $this->assertCount(1, $dql->getDQLPart('join'));
        $this->assertCount(1, $dql->getDQLPart('join')['classtest1']);

        $this->assertEquals('classtest1.classtest7', $dql->getDQLPart('join')['classtest1'][0]->getJoin());
        $this->assertEquals('classtest1__class7actif', $dql->getDQLPart('join')['classtest1'][0]->getAlias());
        $this->assertEquals('LEFT', $dql->getDQLPart('join')['classtest1'][0]->getJoinType());

        $this->assertEquals('WITH', $dql->getDQLPart('join')['classtest1'][0]->getConditionType());
        $this->assertEquals('actif=1', $dql->getDQLPart('join')['classtest1'][0]->getCondition());
    }

    public function testPropertyAttributeNever()
    {
        $dql = $this->entityManager->getRepository(ClassTest1::class)->getDQL((new DqlOptions)->with('classtest1__classtest7'));

        $this->assertCount(1, $dql->getDQLPart('from'));
        $this->assertEquals(ClassTest1::class, $dql->getDQLPart('from')[0]->getFrom());
        $this->assertEquals('classtest1', $dql->getDQLPart('from')[0]->getAlias());

        $this->assertCount(1, $dql->getDQLPart('join'));
        $this->assertCount(1, $dql->getDQLPart('join')['classtest1']);

        $this->assertEquals('classtest1.classtest7', $dql->getDQLPart('join')['classtest1'][0]->getJoin());
        $this->assertEquals('classtest1__classtest7', $dql->getDQLPart('join')['classtest1'][0]->getAlias());
        $this->assertEquals('LEFT', $dql->getDQLPart('join')['classtest1'][0]->getJoinType());

        $this->assertNull($dql->getDQLPart('join')['classtest1'][0]->getConditionType());
        $this->assertNull($dql->getDQLPart('join')['classtest1'][0]->getCondition());
    }

    public function testPropertyAttributeWhenAlias()
    {
        $dql = $this->entityManager->getRepository(ClassTest7::class)->getDQL((new DqlOptions));

        $this->assertCount(1, $dql->getDQLPart('from'));
        $this->assertEquals(ClassTest7::class, $dql->getDQLPart('from')[0]->getFrom());
        $this->assertEquals('classtest7', $dql->getDQLPart('from')[0]->getAlias());

        $this->assertCount(1, $dql->getDQLPart('join'));
        $this->assertCount(1, $dql->getDQLPart('join')['classtest7']);

        $this->assertEquals('classtest7.classtest3', $dql->getDQLPart('join')['classtest7'][0]->getJoin());
        $this->assertEquals('classtest7__classtest3', $dql->getDQLPart('join')['classtest7'][0]->getAlias());
        $this->assertEquals('LEFT', $dql->getDQLPart('join')['classtest7'][0]->getJoinType());

        $this->assertNull($dql->getDQLPart('join')['classtest7'][0]->getConditionType());
        $this->assertNull($dql->getDQLPart('join')['classtest7'][0]->getCondition());
    }

    public function testMultiplePropertyAttributeManyMatchesAlias1()
    {
        $dql = $this->entityManager->getRepository(ClassTest7::class)->getDQL((new DqlOptions)->with('classtest7__aliastest1'));

        $this->assertCount(1, $dql->getDQLPart('from'));
        $this->assertEquals(ClassTest7::class, $dql->getDQLPart('from')[0]->getFrom());
        $this->assertEquals('classtest7', $dql->getDQLPart('from')[0]->getAlias());

        $this->assertCount(1, $dql->getDQLPart('join'));
        $this->assertCount(2, $dql->getDQLPart('join')['classtest7']);

        $this->assertEquals('classtest7.classtest3', $dql->getDQLPart('join')['classtest7'][0]->getJoin());
        $this->assertEquals('classtest7__classtest3', $dql->getDQLPart('join')['classtest7'][0]->getAlias());
        $this->assertEquals('LEFT', $dql->getDQLPart('join')['classtest7'][0]->getJoinType());

        $this->assertEquals('classtest7.classtest5', $dql->getDQLPart('join')['classtest7'][1]->getJoin());
        $this->assertEquals('classtest7__aliastest1', $dql->getDQLPart('join')['classtest7'][1]->getAlias());
        $this->assertEquals('LEFT', $dql->getDQLPart('join')['classtest7'][1]->getJoinType());

        $this->assertEquals('WITH', $dql->getDQLPart('join')['classtest7'][1]->getConditionType());
        $this->assertEquals('classtest7__aliastest1.type=1', $dql->getDQLPart('join')['classtest7'][1]->getCondition());
    }

    public function testMultiplePropertyAttributeManyMatchesAlias2()
    {
        $dql = $this->entityManager->getRepository(ClassTest7::class)->getDQL((new DqlOptions)->with('classtest7__aliastest2'));

        $this->assertCount(1, $dql->getDQLPart('from'));
        $this->assertEquals(ClassTest7::class, $dql->getDQLPart('from')[0]->getFrom());
        $this->assertEquals('classtest7', $dql->getDQLPart('from')[0]->getAlias());

        $this->assertCount(1, $dql->getDQLPart('join'));
        $this->assertCount(2, $dql->getDQLPart('join')['classtest7']);

        $this->assertEquals('classtest7.classtest3', $dql->getDQLPart('join')['classtest7'][0]->getJoin());
        $this->assertEquals('classtest7__classtest3', $dql->getDQLPart('join')['classtest7'][0]->getAlias());
        $this->assertEquals('LEFT', $dql->getDQLPart('join')['classtest7'][0]->getJoinType());

        $this->assertEquals('classtest7.classtest5', $dql->getDQLPart('join')['classtest7'][1]->getJoin());
        $this->assertEquals('classtest7__aliastest2', $dql->getDQLPart('join')['classtest7'][1]->getAlias());
        $this->assertEquals('LEFT', $dql->getDQLPart('join')['classtest7'][1]->getJoinType());

        $this->assertEquals('WITH', $dql->getDQLPart('join')['classtest7'][1]->getConditionType());
        $this->assertEquals('classtest7__aliastest2.type=2', $dql->getDQLPart('join')['classtest7'][1]->getCondition());
    }

    public function testMultiplePropertyAttributeManyMatchesNoAlias()
    {
        $dql = $this->entityManager->getRepository(ClassTest7::class)->getDQL((new DqlOptions)->with('classtest7__classtest5'));

        $this->assertCount(1, $dql->getDQLPart('from'));
        $this->assertEquals(ClassTest7::class, $dql->getDQLPart('from')[0]->getFrom());
        $this->assertEquals('classtest7', $dql->getDQLPart('from')[0]->getAlias());

        $this->assertCount(1, $dql->getDQLPart('join'));
        $this->assertCount(2, $dql->getDQLPart('join')['classtest7']);
        $this->assertNull($dql->getDQLPart('where'));

        $this->assertEquals('classtest7.classtest3', $dql->getDQLPart('join')['classtest7'][0]->getJoin());
        $this->assertEquals('classtest7__classtest3', $dql->getDQLPart('join')['classtest7'][0]->getAlias());
        $this->assertEquals('LEFT', $dql->getDQLPart('join')['classtest7'][0]->getJoinType());

        $this->assertEquals('classtest7.classtest5', $dql->getDQLPart('join')['classtest7'][1]->getJoin());
        $this->assertEquals('classtest7__classtest5', $dql->getDQLPart('join')['classtest7'][1]->getAlias());
        $this->assertEquals('LEFT', $dql->getDQLPart('join')['classtest7'][1]->getJoinType());

        $this->assertEquals('WITH', $dql->getDQLPart('join')['classtest7'][1]->getConditionType());
        $this->assertEquals('classtest7__classtest5.type=7', $dql->getDQLPart('join')['classtest7'][1]->getCondition());
        $this->assertNull($dql->getDQLPart('join')['classtest7'][0]->getIndexBy());
    }

    public function testIndexBy()
    {
        $dql = $this->entityManager->getRepository(ClassTest8::class)->getDQL((new DqlOptions)->with('mySuperAlias8__classtest3'));

        $this->assertCount(1, $dql->getDQLPart('from'));
        $this->assertEquals(ClassTest8::class, $dql->getDQLPart('from')[0]->getFrom());
        $this->assertEquals('mySuperAlias8', $dql->getDQLPart('from')[0]->getAlias());

        $this->assertCount(1, $dql->getDQLPart('join'));
        $this->assertCount(1, $dql->getDQLPart('join')['mySuperAlias8']);
        $this->assertNull($dql->getDQLPart('where'));

        $this->assertEquals('mySuperAlias8.classtest3', $dql->getDQLPart('join')['mySuperAlias8'][0]->getJoin());
        $this->assertEquals('mySuperAlias8__classtest3', $dql->getDQLPart('join')['mySuperAlias8'][0]->getAlias());
        $this->assertEquals('LEFT', $dql->getDQLPart('join')['mySuperAlias8'][0]->getJoinType());
        $this->assertEquals('mySuperAlias8__classtest3.idForIndexBy', $dql->getDQLPart('join')['mySuperAlias8'][0]->getIndexBy());
    }

    public function testIndexByWithoutAlias()
    {
        $dql = $this->entityManager->getRepository(ClassTest8::class)->getDQL((new DqlOptions)->with('mySuperAlias8__classtest5'));

        $this->assertCount(1, $dql->getDQLPart('from'));
        $this->assertEquals(ClassTest8::class, $dql->getDQLPart('from')[0]->getFrom());
        $this->assertEquals('mySuperAlias8', $dql->getDQLPart('from')[0]->getAlias());

        $this->assertCount(1, $dql->getDQLPart('join'));
        $this->assertCount(1, $dql->getDQLPart('join')['mySuperAlias8']);
        $this->assertNull($dql->getDQLPart('where'));

        $this->assertEquals('mySuperAlias8.classtest5', $dql->getDQLPart('join')['mySuperAlias8'][0]->getJoin());
        $this->assertEquals('mySuperAlias8__classtest5', $dql->getDQLPart('join')['mySuperAlias8'][0]->getAlias());
        $this->assertEquals('LEFT', $dql->getDQLPart('join')['mySuperAlias8'][0]->getJoinType());
        $this->assertEquals('idForIndexByWithoutAlias', $dql->getDQLPart('join')['mySuperAlias8'][0]->getIndexBy());
    }

    public function testCallback()
    {
        $dql = $this->entityManager->getRepository(ClassTest8::class)->getDQL((new DqlOptions)->with('mySuperAlias8__classtest4'));

        $this->assertCount(1, $dql->getDQLPart('from'));
        $this->assertEquals(ClassTest8::class, $dql->getDQLPart('from')[0]->getFrom());
        $this->assertEquals('mySuperAlias8', $dql->getDQLPart('from')[0]->getAlias());

        $this->assertCount(1, $dql->getDQLPart('join'));
        $this->assertCount(1, $dql->getDQLPart('join')['mySuperAlias8']);

        $this->assertEquals('mySuperAlias8.classtest4', $dql->getDQLPart('join')['mySuperAlias8'][0]->getJoin());
        $this->assertEquals('mySuperAlias8__classtest4', $dql->getDQLPart('join')['mySuperAlias8'][0]->getAlias());
        $this->assertEquals('LEFT', $dql->getDQLPart('join')['mySuperAlias8'][0]->getJoinType());

        $this->assertEquals('mySuperAlias8.property = :something', $dql->getDQLPart('where')->getParts()[0]);
    }
}
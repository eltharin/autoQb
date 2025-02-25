<?php

namespace EltharinAutoQBTests;

use Eltharin\AutoQbBundle\Exception\UnknownRelation;
use Eltharin\AutoQbBundle\Objects\DqlOptions;
use EltharinAutoQBTests\Entity\ClassTest1;
use EltharinAutoQBTests\Entity\ClassTest8;

class InlineTest extends AbstractTestCase
{/*
    public function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $category = new Category();
        $category->setText('category 1');

        $article = new Article();
        $article->setTitle('titre 1');
        $article->setCategory($category);

        $this->entityManager->persist($category);
        $this->entityManager->persist($article);
        $this->entityManager->flush();
        $this->entityManager->clear();
    }*/
/*
    public function testSetUp()
    {
        $results = $this->entityManager->getRepository(Article::class)->findAll();

        $this->assertCount(1, $results);
        $this->assertEquals('titre 1', $results[0]->getTitle());
    }*/

    public function testSimpleWithNoJoin()
    {
        $dql = $this->entityManager->getRepository(ClassTest1::class)->getDQL();

        $this->assertCount(1, $dql->getDQLPart('from'));
        $this->assertEquals(ClassTest1::class, $dql->getDQLPart('from')[0]->getFrom());
        $this->assertEquals('classtest1', $dql->getDQLPart('from')[0]->getAlias());
        $this->assertCount(0, $dql->getDQLPart('join'));
    }


    public function testWithJoin()
    {
        $dql = $this->entityManager->getRepository(ClassTest1::class)->getDQL((new DqlOptions)->with('classtest1__classtest2'));

        $this->assertCount(1, $dql->getDQLPart('from'));
        $this->assertEquals(ClassTest1::class, $dql->getDQLPart('from')[0]->getFrom());
        $this->assertEquals('classtest1', $dql->getDQLPart('from')[0]->getAlias());

        $this->assertCount(1, $dql->getDQLPart('join'));
        $this->assertCount(1, $dql->getDQLPart('join')['classtest1']);

        $this->assertEquals('classtest1.classtest2', $dql->getDQLPart('join')['classtest1'][0]->getJoin());
        $this->assertEquals('classtest1__classtest2', $dql->getDQLPart('join')['classtest1'][0]->getAlias());
        $this->assertEquals('LEFT', $dql->getDQLPart('join')['classtest1'][0]->getJoinType());

    }

    public function testUnknownWith()
    {
        $this->expectException(UnknownRelation::class);
        $dql = $this->entityManager->getRepository(ClassTest1::class)->getDQL((new DqlOptions)->with('classtest1__classtest3'));
    }

    public function testWithJoinMultiple()
    {
        $dql = $this->entityManager->getRepository(ClassTest1::class)->getDQL(
            (new DqlOptions)
                ->with('classtest1__classtest2')
                ->with('classtest1__classtest5')
        );

        $this->assertCount(1, $dql->getDQLPart('from'));
        $this->assertEquals(ClassTest1::class, $dql->getDQLPart('from')[0]->getFrom());
        $this->assertEquals('classtest1', $dql->getDQLPart('from')[0]->getAlias());

        $this->assertCount(1, $dql->getDQLPart('join'));
        $this->assertCount(2, $dql->getDQLPart('join')['classtest1']);

        $this->assertEquals('classtest1.classtest2', $dql->getDQLPart('join')['classtest1'][0]->getJoin());
        $this->assertEquals('classtest1__classtest2', $dql->getDQLPart('join')['classtest1'][0]->getAlias());
        $this->assertEquals('LEFT', $dql->getDQLPart('join')['classtest1'][0]->getJoinType());

        $this->assertEquals('classtest1.classtest5', $dql->getDQLPart('join')['classtest1'][1]->getJoin());
        $this->assertEquals('classtest1__classtest5', $dql->getDQLPart('join')['classtest1'][1]->getAlias());
        $this->assertEquals('LEFT', $dql->getDQLPart('join')['classtest1'][1]->getJoinType());

    }

    public function testWithJoin2deepth()
    {
        $dql = $this->entityManager->getRepository(ClassTest1::class)->getDQL((new DqlOptions)->with('classtest1__classtest2__classtest3'));

        $this->assertCount(1, $dql->getDQLPart('from'));
        $this->assertEquals(ClassTest1::class, $dql->getDQLPart('from')[0]->getFrom());
        $this->assertEquals('classtest1', $dql->getDQLPart('from')[0]->getAlias());

        $this->assertCount(1, $dql->getDQLPart('join'));
        $this->assertCount(2, $dql->getDQLPart('join')['classtest1']);

        $this->assertEquals('classtest1.classtest2', $dql->getDQLPart('join')['classtest1'][0]->getJoin());
        $this->assertEquals('classtest1__classtest2', $dql->getDQLPart('join')['classtest1'][0]->getAlias());
        $this->assertEquals('LEFT', $dql->getDQLPart('join')['classtest1'][0]->getJoinType());

        $this->assertEquals('classtest1__classtest2.classtest3', $dql->getDQLPart('join')['classtest1'][1]->getJoin());
        $this->assertEquals('classtest1__classtest2__classtest3', $dql->getDQLPart('join')['classtest1'][1]->getAlias());
        $this->assertEquals('LEFT', $dql->getDQLPart('join')['classtest1'][1]->getJoinType());

    }

    public function testAliasFromOptions()
    {
        $dql = $this->entityManager->getRepository(ClassTest8::class)->getDQL((new DqlOptions('mySuperAliasFromOption'))->with('mySuperAliasFromOption__classtest3'));

        $this->assertCount(1, $dql->getDQLPart('from'));
        $this->assertEquals(ClassTest8::class, $dql->getDQLPart('from')[0]->getFrom());
        $this->assertEquals('mySuperAliasFromOption', $dql->getDQLPart('from')[0]->getAlias());

        $this->assertCount(1, $dql->getDQLPart('join'));
        $this->assertCount(1, $dql->getDQLPart('join')['mySuperAliasFromOption']);

        $this->assertEquals('mySuperAliasFromOption.classtest3', $dql->getDQLPart('join')['mySuperAliasFromOption'][0]->getJoin());
        $this->assertEquals('mySuperAliasFromOption__classtest3', $dql->getDQLPart('join')['mySuperAliasFromOption'][0]->getAlias());
        $this->assertEquals('LEFT', $dql->getDQLPart('join')['mySuperAliasFromOption'][0]->getJoinType());
    }

    public function testAliasFromRepository()
    {
        $dql = $this->entityManager->getRepository(ClassTest8::class)->getDQL((new DqlOptions)->with('mySuperAlias8__classtest3'));

        $this->assertCount(1, $dql->getDQLPart('from'));
        $this->assertEquals(ClassTest8::class, $dql->getDQLPart('from')[0]->getFrom());
        $this->assertEquals('mySuperAlias8', $dql->getDQLPart('from')[0]->getAlias());

        $this->assertCount(1, $dql->getDQLPart('join'));
        $this->assertCount(1, $dql->getDQLPart('join')['mySuperAlias8']);

        $this->assertEquals('mySuperAlias8.classtest3', $dql->getDQLPart('join')['mySuperAlias8'][0]->getJoin());
        $this->assertEquals('mySuperAlias8__classtest3', $dql->getDQLPart('join')['mySuperAlias8'][0]->getAlias());
        $this->assertEquals('LEFT', $dql->getDQLPart('join')['mySuperAlias8'][0]->getJoinType());
    }


    public function testchangeSeparator()
    {
        $dql = $this->entityManager->getRepository(ClassTest1::class)->getDQL((new DqlOptions(separator: '#'))->with('classtest1#classtest2#classtest3'));

        $this->assertCount(1, $dql->getDQLPart('from'));
        $this->assertEquals(ClassTest1::class, $dql->getDQLPart('from')[0]->getFrom());
        $this->assertEquals('classtest1', $dql->getDQLPart('from')[0]->getAlias());

        $this->assertCount(1, $dql->getDQLPart('join'));
        $this->assertCount(2, $dql->getDQLPart('join')['classtest1']);

        $this->assertEquals('classtest1.classtest2', $dql->getDQLPart('join')['classtest1'][0]->getJoin());
        $this->assertEquals('classtest1#classtest2', $dql->getDQLPart('join')['classtest1'][0]->getAlias());
        $this->assertEquals('LEFT', $dql->getDQLPart('join')['classtest1'][0]->getJoinType());

        $this->assertEquals('classtest1#classtest2.classtest3', $dql->getDQLPart('join')['classtest1'][1]->getJoin());
        $this->assertEquals('classtest1#classtest2#classtest3', $dql->getDQLPart('join')['classtest1'][1]->getAlias());
        $this->assertEquals('LEFT', $dql->getDQLPart('join')['classtest1'][1]->getJoinType());

    }
}

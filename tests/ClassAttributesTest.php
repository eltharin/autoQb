<?php

namespace EltharinAutoQBTests;

use Eltharin\AutoQbBundle\DataCollector\AutoQbCollector;
use EltharinAutoQBTests\Entity\Article;
use EltharinAutoQBTests\Entity\ClassWithAttributeMtM;
use EltharinAutoQBTests\Entity\ClassWithAttributeMtO;
use EltharinAutoQBTests\Entity\ClassWithAttributeOtM;
use EltharinAutoQBTests\Entity\ClassWithAttributeOtO;

class ClassAttributes//Test extends AbstractTestCase
{
    public function testclassWithOtO()
    {
        var_dump(get_class($this->entityManager->getRepository(ClassWithAttributeOtO::class)));
        $dql = $this->entityManager->getRepository(ClassWithAttributeOtO::class)->getDQL();

        $this->assertCount(1, $dql->getDQLPart('from'));
        $this->assertEquals(ClassWithAttributeOtO::class, $dql->getDQLPart('from')[0]->getFrom());
        $this->assertEquals('cwaOto', $dql->getDQLPart('from')[0]->getAlias());

        $this->assertCount(1, $dql->getDQLPart('join'));
        $this->assertCount(1, $dql->getDQLPart('join')['cwaOto']);

        $this->assertEquals('cwaOto.otooto', $dql->getDQLPart('join')['cwaOto'][0]->getJoin());
        $this->assertEquals('cwaOto__otooto', $dql->getDQLPart('join')['cwaOto'][0]->getAlias());
        $this->assertEquals('LEFT', $dql->getDQLPart('join')['cwaOto'][0]->getJoinType());
    }

    public function testclassWithOtM()
    {
        $dql = $this->entityManager->getRepository(ClassWithAttributeOtM::class)->getDQL();

        $this->assertCount(1, $dql->getDQLPart('from'));
        $this->assertEquals(ClassWithAttributeOtM::class, $dql->getDQLPart('from')[0]->getFrom());
        $this->assertEquals('cwaOtm', $dql->getDQLPart('from')[0]->getAlias());

        $this->assertCount(1, $dql->getDQLPart('join'));
        $this->assertCount(1, $dql->getDQLPart('join')['cwaOtm']);

        $this->assertEquals('cwaOtm.otmotm', $dql->getDQLPart('join')['cwaOtm'][0]->getJoin());
        $this->assertEquals('cwaOtm__otmotm', $dql->getDQLPart('join')['cwaOtm'][0]->getAlias());
        $this->assertEquals('LEFT', $dql->getDQLPart('join')['cwaOtm'][0]->getJoinType());
    }

    public function testclassWithMtO()
    {
        $dql = $this->entityManager->getRepository(ClassWithAttributeMtO::class)->getDQL();

        $this->assertCount(1, $dql->getDQLPart('from'));
        $this->assertEquals(ClassWithAttributeMtO::class, $dql->getDQLPart('from')[0]->getFrom());
        $this->assertEquals('cwaMto', $dql->getDQLPart('from')[0]->getAlias());

        $this->assertCount(1, $dql->getDQLPart('join'));
        $this->assertCount(1, $dql->getDQLPart('join')['cwaMto']);

        $this->assertEquals('cwaMto.mtomto', $dql->getDQLPart('join')['cwaMto'][0]->getJoin());
        $this->assertEquals('cwaMto__mtomto', $dql->getDQLPart('join')['cwaMto'][0]->getAlias());
        $this->assertEquals('LEFT', $dql->getDQLPart('join')['cwaMto'][0]->getJoinType());
    }

    public function testclassWithMtM()
    {
        $dql = $this->entityManager->getRepository(ClassWithAttributeMtM::class)->getDQL();

        $this->assertCount(1, $dql->getDQLPart('from'));
        $this->assertEquals(ClassWithAttributeMtM::class, $dql->getDQLPart('from')[0]->getFrom());
        $this->assertEquals('cwaMtm', $dql->getDQLPart('from')[0]->getAlias());

        $this->assertCount(1, $dql->getDQLPart('join'));
        $this->assertCount(1, $dql->getDQLPart('join')['cwaMtm']);

        $this->assertEquals('cwaMtm.mtmmtm', $dql->getDQLPart('join')['cwaMtm'][0]->getJoin());
        $this->assertEquals('cwaMtm__mtmmtm', $dql->getDQLPart('join')['cwaMtm'][0]->getAlias());
        $this->assertEquals('LEFT', $dql->getDQLPart('join')['cwaMtm'][0]->getJoinType());
    }
}
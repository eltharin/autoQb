<?php


use Eltharin\AutoQbBundle\Attributes\AutoQbField;
use Eltharin\AutoQbBundle\DataCollector\AutoQbCollector;
use Eltharin\AutoQbBundle\DataCollector\DataObject;
use Eltharin\AutoQbBundle\Objects\DqlOptions;
use EltharinAutoQBTests\Entity\ClassTest1;
use EltharinAutoQBTests\Entity\ClassTest2;
use EltharinAutoQBTests\Entity\ClassTest3;
use EltharinAutoQBTests\Entity\ClassTest4;
use EltharinAutoQBTests\Entity\ClassTest5;
use EltharinAutoQBTests\Entity\ClassTest6;
use EltharinAutoQBTests\Entity\ClassTest7;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DataCollectorTest extends \EltharinAutoQBTests\AbstractTestCase
{
    public function testWithJoin2deepth()
    {
        $dql = $this->entityManager->getRepository(ClassTest1::class)->getDQL((new DqlOptions)->with('classtest1__classtest2__classtest3'));

        $dataColector = new AutoQbCollector();
        $dataColector->collect(new Request(), new Response());

        $this->assertCount(1, $dataColector->getData());
        $this->assertInstanceOf(DataObject::class, $dataColector->getData()[0]);

        $log = $dataColector->getData()[0]->getLog();

        $this->assertEquals('classtest1', $log['alias']);
        $this->assertEquals(ClassTest1::class, $log['entityName']);

        $this->assertCount(4, $log['relations']);

        $this->assertEquals('classtest1__classtest2', $log['relations'][0]['alias']);
        $this->assertEquals(ClassTest2::class, $log['relations'][0]['entityName']);
        $this->assertTrue($log['relations'][0]['result']);

        $this->assertEquals('classtest1__classtest5', $log['relations'][1]['alias']);
        $this->assertEquals(ClassTest5::class, $log['relations'][1]['entityName']);
        $this->assertFalse($log['relations'][1]['result']);

        $this->assertEquals('classtest1__classtest6', $log['relations'][2]['alias']);
        $this->assertEquals(ClassTest6::class, $log['relations'][2]['entityName']);
        $this->assertFalse($log['relations'][2]['result']);

        $this->assertEquals('classtest1__classtest7', $log['relations'][3]['alias']);
        $this->assertEquals(ClassTest7::class, $log['relations'][3]['entityName']);
        $this->assertFalse($log['relations'][3]['result']);

        $this->assertCount(2, $log['relations'][0]['relations']);

        $this->assertEquals('classtest1__classtest2__classtest3', $log['relations'][0]['relations'][0]['alias']);
        $this->assertEquals(ClassTest3::class, $log['relations'][0]['relations'][0]['entityName']);
        $this->assertTrue($log['relations'][0]['relations'][0]['result']);

        $this->assertEquals('classtest1__classtest2__classtest4', $log['relations'][0]['relations'][1]['alias']);
        $this->assertEquals(ClassTest4::class, $log['relations'][0]['relations'][1]['entityName']);
        $this->assertFalse($log['relations'][0]['relations'][1]['result']);

        $this->assertCount(0, $log['relations'][0]['relations'][0]['relations']);
    }
}
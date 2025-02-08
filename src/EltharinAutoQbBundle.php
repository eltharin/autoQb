<?php

namespace Eltharin\AutoQbBundle;

use Eltharin\AutoQbBundle\DataCollector\AutoQbCollector;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;
use Symfony\Component\Yaml\Parser;

class EltharinAutoQbBundle extends AbstractBundle
{
	public function prependExtension(ContainerConfigurator $container, ContainerBuilder $builder): void
	{
		$container->services()
			->set(AutoQbCollector::class)
			->tag('data_collector',['id' => AutoQbCollector::class,'template' => '@EltharinAutoQb/data_collector/template.html.twig'])
		;
	}
}

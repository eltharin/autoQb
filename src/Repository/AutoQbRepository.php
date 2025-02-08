<?php

namespace Eltharin\AutoQbBundle\Repository;

use Doctrine\ORM\QueryBuilder;
use Eltharin\AutoQbBundle\DataCollector\AutoQbCollector;
use Eltharin\AutoQbBundle\Objects\DqlOptions;
use Eltharin\AutoQbBundle\Service\QueryBuilderMaker;

trait AutoQbRepository
{
	protected ?string $autoQbAlias = null;

	public function getDQL(?DqlOptions $options = null) : QueryBuilder
	{
		if(is_null($options))
		{
			$options = new DqlOptions();
		}

		$this->autoQbAlias = $options->getAlias() ?? $this->autoQbAlias ?? $this->getClassMetadata()->getTableName();
		$qb = $this->createQueryBuilder($this->autoQbAlias);

        $log = [];

        (new QueryBuilderMaker($qb, $this->getEntityManager(), $options->getSeparator()))
            ->addJoins($this->autoQbAlias, $this->getEntityName(), with: $options->getWith()[$this->autoQbAlias] ?? [], log: $log);

        AutoQbCollector::addData($log, $qb);

		return $qb;
	}

	public function findAll(array|DqlOptions $options = new DqlOptions) : array
	{
		return $this->getDQL($options)->getQuery()->getResult();
	}
}

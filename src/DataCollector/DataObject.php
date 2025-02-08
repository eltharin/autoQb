<?php

namespace Eltharin\AutoQbBundle\DataCollector;

use Doctrine\ORM\QueryBuilder;

class DataObject
{
	protected array $log = [];
	protected QueryBuilder $qb;
	protected string $query = '';

	public function __construct(array $log, QueryBuilder $qb)
	{
		$this->log = $log;
		$this->qb = $qb;
		$this->query = '';
	}

	public function __serialize(): array
	{
		return [
			'log' => $this->log,
			'query' => $this->qb->getDQL()
		];
	}

    public function getLog() : array
    {
        return $this->log;
    }

    public function getQuery() : string
    {
        return $this->query;
    }

	public function __call(string $name, array $arguments)
	{
		dump($name);
	}
}
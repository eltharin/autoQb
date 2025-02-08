<?php

namespace Eltharin\AutoQbBundle\DataCollector;

use Symfony\Bundle\FrameworkBundle\DataCollector\AbstractDataCollector;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\VarDumper\Cloner\Data;

class AutoQbCollector extends AbstractDataCollector
{
	protected static $staticData = [];
	protected Data|array $data = [];

	public function collect(Request $request, Response $response, ?\Throwable $exception = null) : void
	{
		$this->data = self::$staticData;
	}

	public static function addData($log, $qb)
	{
		self::$staticData[] = new DataObject($log, $qb);
	}

	public function getData()
	{
		return $this->data;
	}
}

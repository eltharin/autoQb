<?php

namespace Eltharin\AutoQbBundle\Objects;

class DqlOptions
{
	private array $with = [];

	public function __construct(private ?string $alias = null, private string $separator = '__')
	{
	}

	public function with(string|array $adds, string $type = 'left') : self
	{
		if(is_string($adds))
		{
            $pointer = &$this->with;

            foreach(explode($this->separator, $adds) as $add)
            {
                if(!array_key_exists($add, $pointer))
                {
                    $pointer[$add] = [];
                }
                $pointer = &$pointer[$add];
            }
            $pointer = [];
		}
		else
		{
            foreach($adds as $add)
            {
                $this->with($add);
            }
		}
        return $this;
	}

	public function getWith(): array
	{
		return $this->with;
	}

    public function getAlias(): ?string
    {
        return $this->alias;
    }

    public function getSeparator(): string
    {
        return $this->separator;
    }
}
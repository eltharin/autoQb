<?php

namespace Eltharin\AutoQbBundle\Objects;

class DqlOptions
{
	private array $with = [];
	private array $without = [];

	public function __construct(private ?string $alias = null, private string $separator = '__')
	{
	}

    public function with(string|array $adds, string $type = 'left') : self
    {
        if(is_string($adds))
        {
            $pointer = $this->getPointer($this->with, $adds);
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

    public function without(string $remove) : self
    {
        $pointer = $this->getPointer($this->without, $remove);

        return $this;
    }

    protected function getPointer(array &$tab, string $keys)
    {
        $pointer = &$tab;

        foreach(explode($this->separator, $keys) as $key)
        {
            if(!array_key_exists($key, $pointer))
            {
                $pointer[$key] = [];
            }
            $pointer = &$pointer[$key];
        }
        $pointer = [];
    }

    public function getWith(): array
    {
        return $this->with;
    }

    public function getWithout(): array
    {
        return $this->without;
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
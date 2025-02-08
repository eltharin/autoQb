<?php

declare(strict_types=1);

namespace Eltharin\AutoQbBundle\Attributes;

use Attribute;
use Doctrine\ORM\Mapping\MappingAttribute;
use Doctrine\ORM\Query\Expr\Comparison;
use Doctrine\ORM\Query\Expr\Composite;
use Doctrine\ORM\Query\Expr\Func;


#[Attribute(Attribute::TARGET_PROPERTY | Attribute::IS_REPEATABLE)]
class AutoQbField implements MappingAttribute
{
    private array $whenAlias = [];

	public function __construct(
		array|string|null $whenAlias = [],
        private string $relationAlias = '',
        private ?string $indexBy = null, //-- indexBy
        private bool $indexByWithoutAlias = false,
        private string|null $conditionType = null,
        private string|Composite|Comparison|Func|null $condition = null,
        private bool $autoLink = false,
        private bool $select = true,
        private string $joinType = 'left',
        private ?string $callback = null,

	)
    {
        if(!is_array($whenAlias))
        {
            $this->whenAlias = $whenAlias ? [$whenAlias] : [];
        }
    }

    public function getWhenAlias(): array|string|null
    {
        return $this->whenAlias;
    }

    public function getRelationAlias(): string
    {
        return $this->relationAlias;
    }

    public function getIndexBy(): ?string
    {
        return $this->indexBy;
    }

    public function isIndexByWithoutAlias() : bool
    {
        return $this->indexByWithoutAlias;
    }

    public function getCondition(): mixed
    {
        return $this->condition;
    }

    public function isAutoLink(): bool
    {
        return $this->autoLink;
    }

    public function isSelect(): bool
    {
        return $this->select;
    }

    public function getJoinType(): string
    {
        return $this->joinType;
    }

    public function getConditionType(): ?string
    {
        return $this->conditionType;
    }

    public function getCallback(): ?string
    {
        return $this->callback;
    }
}

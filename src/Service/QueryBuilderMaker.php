<?php

namespace Eltharin\AutoQbBundle\Service;

use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\EntityManager;
use Eltharin\AutoQbBundle\Attributes\AutoQbField;
use Eltharin\AutoQbBundle\Exception\UnknownRelation;

class QueryBuilderMaker
{
    public function __construct(protected QueryBuilder $qb, protected EntityManager $entityManager, protected string $separator)
    {
    }

    public function addJoins(string $alias, string $entityName, $from = [], $count = 0, ?array $with = [], ?array &$log = null): void
    {
        $log['relations'] = [];
        $log['alias'] = $alias;
        $log['entityName'] = $entityName;

        foreach($this->entityManager->getClassMetadata($entityName)->associationMappings as $assoc)
        {
            $logAssoc = [
                'property' => $assoc['fieldName'],
                'alias' => $alias . $this->separator . $assoc['fieldName'],
                'entityName' => $assoc['targetEntity'],
                'result' => false,
                'attributes' => [],
                'subJoins' => [],
            ];
            $propertyAttribute = self::getPropertyAttribute($assoc['sourceEntity'], $assoc['fieldName'], $alias, $with ?? [], $logAssoc['attributes']);

            if($propertyAttribute !== null)
            {
                $relAlias = $propertyAttribute->getRelationAlias() ?: $assoc['fieldName'];
                $subAlias = $alias . $this->separator . $relAlias;

                if($propertyAttribute->isSelect())
                {
                    $this->qb->addSelect($subAlias);
                }

                $indexBy = $propertyAttribute->getIndexBy() === null ? null :
                    (!$propertyAttribute->isIndexByWithoutAlias() ? $subAlias . '.' : '' ) . $propertyAttribute->getIndexBy();

                $this->qb->{$propertyAttribute->getJoinType() . 'Join'}(
                    $alias . '.' . $assoc['fieldName'],
                    $subAlias,
                    $propertyAttribute->getConditionType(),
                    is_string($propertyAttribute->getCondition()) ? str_replace('##alias##',$subAlias,$propertyAttribute->getCondition()) : $propertyAttribute->getCondition(),
                    $indexBy);
                $from[] = $relAlias;

                try{
                    $this->addJoins($subAlias, $assoc['targetEntity'], $from, $count+1, $with[$relAlias]??[], $logAssoc);
                } catch(UnknownRelation $e) {
                    $log['error'][] = $e->getMessage();
                }

                $logAssoc['alias'] = $subAlias;
                $logAssoc['attribute'] = $propertyAttribute;
                $logAssoc['result'] = true;

                if($propertyAttribute->getCallback() !== null)
                {
                    $this->entityManager->getRepository($entityName)->{$propertyAttribute->getCallback()}($this->qb, $assoc, $propertyAttribute, $alias, $subAlias, $this->separator, $from, $count, $with);
                }

                unset($with[$relAlias]);
            }
            $log['relations'][] = $logAssoc;
        }

        if(!empty($with))
        {
            throw new UnknownRelation(implode(', ', array_map(fn($a) => $alias . '.' . $a, array_keys($with))) . ' not exists.');
        }

    }

	protected function getPropertyAttribute(string $name, string $property, string $classAlias, array $with, array &$log) : ?AutoQbField
	{
        foreach($this->entityManager->getClassMetadata($name)
                    ->getReflectionClass()
                    ->getProperty($property)
                    ->getAttributes(AutoQbField::class) as $key => $attr)
        {
            $attr = $attr->newInstance();
            /** @var AutoQbField $attr */

            $log[$key] = ['attr' => $attr, 'result' => null, 'reason' => ''];

            if(!empty($attr->getWhenAlias()) && !in_array($classAlias, $attr->getWhenAlias()))
            {
                $log[$key]['result'] = false;
                $log[$key]['reason'] = $classAlias . ' not in ' . implode(', ', $attr->getWhenAlias());
                continue;
            }


            //cas1 : l'alias de la relation est demandée
            if($attr->getRelationAlias() != '')
            {
                if(array_key_exists($attr->getRelationAlias(), $with))
                {
                    $log[$key]['result'] = true;
                    $log[$key]['reason'] = 'alias "' . $attr->getRelationAlias() . '" is ask.';
                    return $attr;
                }
                $log[$key]['result'] = false;
                $log[$key]['reason'] = 'alias "' . $attr->getRelationAlias() . '" is not ask.';
                continue;
            }

            //cas2: la relation est demandée
            if(array_key_exists($property, $with))
            {
                $log[$key]['result'] = true;
                $log[$key]['reason'] = 'property "' . $property . '" is ask.';
                return $attr;
            }

            //cas3 la relation n'est pas demandée mais est automatique

            if($attr->isAutoLink())
            {
                $log[$key]['result'] = true;
                $log[$key]['reason'] = 'is auto linked';
                return $attr;
            }

            $log[$key]['result'] = false;
            $log[$key]['reason'] = 'attr is not ask.';
        }

        if(array_key_exists($property, $with))
        {
            $log[] = [
                'result' => true,
                'reason' => 'property "' . $property . '" is ask without attribute.',
            ];

            return new AutoQbField();
        }

        $log[] = [
            'result' => false,
            'reason' => 'property "' . $property . '" is not ask.',
        ];

		return null;
	}
}

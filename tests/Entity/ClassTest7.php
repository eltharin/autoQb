<?php

namespace EltharinAutoQBTests\Entity;

use Doctrine\ORM\Mapping as ORM;
use Eltharin\AutoQbBundle\Attributes\AutoQbField;
use EltharinAutoQBTests\Repository\CommonRepository;

#[ORM\Entity(repositoryClass: CommonRepository::class)]
#[ORM\Table(name: 'classtest7')]
class ClassTest7
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $title = null;

    #[ORM\Column]
    private bool $actif = true;

    #[ORM\ManyToOne()]
    #[ORM\JoinColumn(nullable: false)]
    #[AutoQbField(whenAlias: 'classtest7', autoLink: true)]
    private ?ClassTest3 $classtest3 = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[AutoQbField(relationAlias: 'aliastest1', conditionType: 'WITH', condition: '##alias##.type=1')]
    #[AutoQbField(relationAlias: 'aliastest2', conditionType: 'WITH', condition: '##alias##.type=2')]
    #[AutoQbField(conditionType: 'WITH', condition: '##alias##.type=7')]
    private ?ClassTest5 $classtest5 = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function isActif(): bool
    {
        return $this->actif;
    }

    public function setActif(bool $actif): self
    {
        $this->actif = $actif;
        return $this;
    }
}
<?php

namespace EltharinAutoQBTests\Entity;

use Doctrine\ORM\Mapping as ORM;
use Eltharin\AutoQbBundle\Attributes\AutoQbField;
use EltharinAutoQBTests\Repository\CommonRepository;

#[ORM\Entity(repositoryClass: CommonRepository::class)]
#[ORM\Table(name: 'classtest1')]
class ClassTest1
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $title = null;

    #[ORM\ManyToOne()]
    #[ORM\JoinColumn(nullable: false)]
    private ?ClassTest2 $classtest2 = null;

    #[ORM\ManyToOne()]
    #[ORM\JoinColumn(nullable: false)]
    private ?ClassTest5 $classtest5 = null;

    #[ORM\ManyToOne()]
    #[ORM\JoinColumn(nullable: false)]
    private ?ClassTest6 $classtest6 = null;

    #[ORM\ManyToOne()]
    #[ORM\JoinColumn(nullable: false)]
    #[AutoQbField(relationAlias: 'class7actif', conditionType: 'WITH', condition: 'actif=1')]
    private ?ClassTest7 $classtest7 = null;

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

}
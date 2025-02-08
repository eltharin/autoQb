<?php

namespace EltharinAutoQBTests\Entity;

use Doctrine\ORM\Mapping as ORM;
use Eltharin\AutoQbBundle\Attributes\AutoQbField;
use EltharinAutoQBTests\Repository\Class8Repository;

#[ORM\Entity(repositoryClass: Class8Repository::class)]
#[ORM\Table(name: 'classtest8')]
class ClassTest8
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
    #[AutoQbField(indexBy: 'idForIndexBy')]
    private ?ClassTest3 $classtest3 = null;

    #[ORM\ManyToOne()]
    #[ORM\JoinColumn(nullable: false)]
    #[AutoQbField(callback: 'myCallbackInRepository')]
    private ?ClassTest4 $classtest4 = null;

    #[ORM\ManyToOne()]
    #[ORM\JoinColumn(nullable: false)]
    #[AutoQbField(indexBy: 'idForIndexByWithoutAlias', indexByWithoutAlias: true)]
    private ?ClassTest3 $classtest5 = null;

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
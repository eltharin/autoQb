<?php

namespace EltharinAutoQBTests\Entity;

use Doctrine\ORM\Mapping as ORM;
use EltharinAutoQBTests\Repository\ArticleRepository;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
#[ORM\Table(name: 'classA')]
class ClassA
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $title = null;

    #[ORM\OneToOne(targetEntity: ClassWithAttributeMtO::class, mappedBy: 'mtooto')]
    private ClassWithAttributeMtO $mtooto;

    #[ORM\ManyToOne(inversedBy: 'mtootm')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ClassWithAttributeMtO $mtomto = null;

    #[ORM\OneToOne(targetEntity: ClassWithAttributeMtM::class, mappedBy: 'mtmoto')]
    private ClassWithAttributeMtM $mtmoto;

    #[ORM\ManyToOne(inversedBy: 'mtmotm')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ClassWithAttributeMtM $mtmmto = null;


    #[ORM\OneToOne(targetEntity: ClassWithAttributeOtO::class, mappedBy: 'otooto')]
    private ClassWithAttributeOtO $otooto;

    #[ORM\ManyToOne(inversedBy: 'otootm')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ClassWithAttributeOtO $otomto = null;

    #[ORM\OneToOne(targetEntity: ClassWithAttributeOtM::class, mappedBy: 'otmoto')]
    private ClassWithAttributeOtM $otmoto;

    #[ORM\ManyToOne(inversedBy: 'otmotm')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ClassWithAttributeOtM $otmmto = null;

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
<?php

namespace EltharinAutoQBTests\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use EltharinAutoQBTests\Repository\ArticleRepository;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
#[ORM\Table(name: 'classB')]
class ClassB
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $title = null;

    #[ORM\OneToMany(targetEntity: ClassWithAttributeMtO::class, mappedBy: 'mtomto')]
    #[ORM\JoinColumn(nullable: false)]
    private Collection $mtootm;

    #[ORM\ManyToMany(targetEntity: ClassWithAttributeMtO::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Collection $mtomtm;


    #[ORM\OneToMany(targetEntity: ClassWithAttributeMtM::class, mappedBy: 'mtmmto')]
    #[ORM\JoinColumn(nullable: false)]
    private Collection $mtmotm;

    #[ORM\ManyToMany(targetEntity: ClassWithAttributeMtM::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Collection $mtmmtm;


    #[ORM\OneToMany(targetEntity: ClassWithAttributeOtO::class, mappedBy: 'otomto')]
    #[ORM\JoinColumn(nullable: false)]
    private Collection $otootm;

    #[ORM\ManyToMany(targetEntity: ClassWithAttributeOtO::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Collection $otomtm;


    #[ORM\OneToMany(targetEntity: ClassWithAttributeOtM::class, mappedBy: 'otmmto')]
    #[ORM\JoinColumn(nullable: false)]
    private Collection $otmotm;

    #[ORM\ManyToMany(targetEntity: ClassWithAttributeOtM::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Collection $otmmtm;

    public function __construct()
    {
        $this->mtootm = new ArrayCollection();
        $this->mtomtm = new ArrayCollection();

        $this->mtmotm = new ArrayCollection();
        $this->mtmmtm = new ArrayCollection();

        $this->otootm = new ArrayCollection();
        $this->otomtm = new ArrayCollection();

        $this->otmotm = new ArrayCollection();
        $this->otmmtm = new ArrayCollection();
    }

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
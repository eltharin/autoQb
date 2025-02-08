<?php

namespace EltharinAutoQBTests\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use EltharinAutoQBTests\Repository\CommonRepository;
use Eltharin\AutoQbBundle\Attributes\AutoQbEntity;

#[ORM\Entity(repositoryClass: CommonRepository::class)]
#[ORM\Table(name: 'cwaOtm')]
#[AutoQbEntity(followOtM: true)]
class ClassWithAttributeOtM
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $title = null;

    #[ORM\OneToMany(targetEntity: ClassTest1::class, mappedBy: 'otmmto')]
    #[ORM\JoinColumn(nullable: false)]
    private Collection $otmotm;

    #[ORM\OneToOne(targetEntity: ClassTest1::class, inversedBy: 'otmoto')]
    private ClassTest1 $otmoto;

    #[ORM\ManyToOne(inversedBy: 'otmotm')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ClassB $otmmto = null;

    #[ORM\ManyToMany(targetEntity: ClassB::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Collection $otmmtm;

    public function __construct()
    {
        $this->otmotm = new ArrayCollection();
        $this->otmmtm = new ArrayCollection();
    }

}
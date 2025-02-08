<?php

namespace EltharinAutoQBTests\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Eltharin\AutoQbBundle\Attributes\AutoQbEntity;
use EltharinAutoQBTests\Repository\CommonRepository;

#[ORM\Entity(repositoryClass: CommonRepository::class)]
#[ORM\Table(name: 'cwaOto')]
#[AutoQbEntity(followOtO: true)]
class ClassWithAttributeOtO
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(targetEntity: ClassTest1::class, mappedBy: 'otomto')]
    #[ORM\JoinColumn(nullable: false)]
    private Collection $otootm;

    #[ORM\OneToOne(targetEntity: ClassTest1::class, inversedBy: 'otooto')]
    private ClassTest1 $otooto;

    #[ORM\ManyToOne(inversedBy: 'otootm')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ClassB $otomto = null;

    #[ORM\ManyToMany(targetEntity: ClassB::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Collection $otomtm;

    public function __construct()
    {
        $this->otootm = new ArrayCollection();
        $this->otomtm = new ArrayCollection();
    }
}
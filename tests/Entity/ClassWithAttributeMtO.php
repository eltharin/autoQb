<?php

namespace EltharinAutoQBTests\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use EltharinAutoQBTests\Repository\CommonRepository;
use Eltharin\AutoQbBundle\Attributes\AutoQbEntity;

#[ORM\Entity(repositoryClass: CommonRepository::class)]
#[ORM\Table(name: 'cwaMto')]
#[AutoQbEntity(followMtO: true)]
class ClassWithAttributeMtO
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $title = null;

    #[ORM\OneToMany(targetEntity: ClassTest1::class, mappedBy: 'mtomto')]
    #[ORM\JoinColumn(nullable: false)]
    private Collection $mtootm;

    #[ORM\OneToOne(targetEntity: ClassTest1::class, inversedBy: 'mtooto')]
    private ClassTest1 $mtooto;

    #[ORM\ManyToOne(inversedBy: 'mtootm')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ClassB $mtomto = null;

    #[ORM\ManyToMany(targetEntity: ClassB::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Collection $mtomtm;

    public function __construct()
    {
        $this->mtootm = new ArrayCollection();
        $this->mtomtm = new ArrayCollection();
    }
}
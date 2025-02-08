<?php

namespace EltharinAutoQBTests\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use EltharinAutoQBTests\Repository\CommonRepository;
use Eltharin\AutoQbBundle\Attributes\AutoQbEntity;

#[ORM\Entity(repositoryClass: CommonRepository::class)]
#[ORM\Table(name: 'cwaMtm')]
#[AutoQbEntity(followMtM: true)]
class ClassWithAttributeMtM
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $title = null;

    #[ORM\OneToMany(targetEntity: ClassTest1::class, mappedBy: 'mtmmto')]
    #[ORM\JoinColumn(nullable: false)]
    private Collection $mtmotm;

    #[ORM\OneToOne(targetEntity: ClassTest1::class, inversedBy: 'mtmoto')]
    private ClassTest1 $mtmoto;

    #[ORM\ManyToOne(inversedBy: 'mtmotm')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ClassB $mtmmto = null;

    #[ORM\ManyToMany(targetEntity: ClassB::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Collection $mtmmtm;

    public function __construct()
    {
        $this->mtmotm = new ArrayCollection();
        $this->mtmmtm = new ArrayCollection();
    }


}
<?php

namespace EltharinAutoQBTests\Entity;

use Doctrine\ORM\Mapping as ORM;
use EltharinAutoQBTests\Repository\CategoryRepository;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[ORM\Table(name: 'tag')]
class Tag
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $text = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setText(?string $text): self
    {
        $this->text = $text;
        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }
}
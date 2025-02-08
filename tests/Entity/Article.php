<?php

namespace EltharinAutoQBTests\Entity;

use Doctrine\ORM\Mapping as ORM;
use Eltharin\AutoQbBundle\Attributes\AutoQbField;
use EltharinAutoQBTests\Entity\Category;
use EltharinAutoQBTests\Entity\ClassTest1;
use EltharinAutoQBTests\Repository\ArticleRepository;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
#[ORM\Table(name: 'article')]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $title = null;

    #[ORM\ManyToOne()]
    #[ORM\JoinColumn(nullable: false)]
    #[AutoQbField(whenAlias: 'aliasWhitchNotExist')]

    #[AutoQbField(autoLink: false, relationAlias: 'allArticles')]
    private ?Category $category = null;

    #[ORM\ManyToOne()]
    private ?ClassTest1 $classa = null;

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

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;
        return $this;
    }
}
<?php

namespace App\Entity;

use App\Repository\RecetteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Entity\User;
use App\Entity\Category;
use Symfony\Component\Serializer\Annotation\Groups;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RecetteRepository::class)]
class Recette
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['getRecette'])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(['getRecette'])]
    private ?string $descriptions = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['getRecette'])]
    private ?string $image = null;

    #[ORM\ManyToOne(inversedBy: 'recettes')]
    #[Groups(['getRecette'])]
    private ?user $users = null;

    #[ORM\ManyToMany(targetEntity: category::class, inversedBy: 'recettes')]
    #[Groups(['getRecette'])]
    private Collection $category;


    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->category = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescriptions(): ?string
    {
        return $this->descriptions;
    }

    public function setDescriptions(string $descriptions): self
    {
        $this->descriptions = $descriptions;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getUsers(): ?user
    {
        return $this->users;
    }

    public function setUsers(?user $users): self
    {
        $this->users = $users;

        return $this;
    }

    /**
     * @return Collection<int, category>
     */
    public function getCategory(): Collection
    {
        return $this->category;
    }

    public function addCategory(category $category): self
    {
        if (!$this->category->contains($category)) {
            $this->category->add($category);
        }

        return $this;
    }

    public function removeCategory(category $category): self
    {
        $this->category->removeElement($category);

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\RecetteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RecetteRepository::class)]
class Recette
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description3 = null;

    #[ORM\Column(length: 255)]
    private ?string $fiche = null;

    #[ORM\Column(length: 255)]
    private ?string $avatar2 = null;

    #[ORM\OneToMany(mappedBy: 'recette', targetEntity: Ingredient::class)]
    private Collection $ingredients;

    #[ORM\ManyToMany(targetEntity: Categorie::class, inversedBy: 'recettes')]
    private Collection $categories;

    #[ORM\OneToMany(targetEntity: Note::class, mappedBy: 'recette')]
    private Collection $notes;

    #[ORM\ManyToOne(inversedBy: 'recettes')]
    private ?User $moderatedBy = null;

    #[ORM\ManyToOne(inversedBy: 'recettes')]
    #[ORM\JoinColumn(nullable: true, onDelete: 'SET NULL')]
    private ?User $user = null;

    public function __construct()
    {
        $this->ingredients = new ArrayCollection();
        $this->categories = new ArrayCollection();
        $this->notes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription3(): ?string
    {
        return $this->description3;
    }

    public function setDescription3(string $description3): static
    {
        $this->description3 = $description3;
        return $this;
    }

    public function getFiche(): ?string
    {
        return $this->fiche;
    }

    public function setFiche(string $fiche): static
    {
        $this->fiche = $fiche;
        return $this;
    }

    public function getAvatar2(): ?string
    {
        return $this->avatar2;
    }

    public function setAvatar2(string $avatar2): static
    {
        $this->avatar2 = $avatar2;
        return $this;
    }

    public function getIngredients(): Collection
    {
        return $this->ingredients;
    }

    public function addIngredient(Ingredient $ingredient): static
    {
        if (!$this->ingredients->contains($ingredient)) {
            $this->ingredients->add($ingredient);
            $ingredient->setRecette($this);
        }

        return $this;
    }

    public function removeIngredient(Ingredient $ingredient): static
    {
        if ($this->ingredients->removeElement($ingredient)) {
            if ($ingredient->getRecette() === $this) {
                $ingredient->setRecette(null);
            }
        }

        return $this;
    }

    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Categorie $category): static
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
        }

        return $this;
    }

    public function removeCategory(Categorie $category): static
    {
        $this->categories->removeElement($category);
        return $this;
    }

    public function getNotes(): Collection
    {
        return $this->notes;
    }

    public function getModeratedBy(): ?User
    {
        return $this->moderatedBy;
    }

    public function setModeratedBy(?User $moderatedBy): static
    {
        $this->moderatedBy = $moderatedBy;
        return $this;
    }
}
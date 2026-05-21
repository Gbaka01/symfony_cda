<?php

namespace App\Entity;

use App\Entity\Recette;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\IngredientRepository;

#[ORM\Entity(repositoryClass: IngredientRepository::class)]
class Ingredient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;
#[ORM\ManyToOne(inversedBy: 'ingredients')]
private ?Recette $recette = null;

public function getRecette(): ?Recette
{
    return $this->recette;
}

public function setRecette(?Recette $recette): static
{
    $this->recette = $recette;
    return $this;
}






    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }



}
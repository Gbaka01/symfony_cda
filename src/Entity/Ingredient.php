<?php
 
namespace App\Entity;
 
use App\Repository\IngredientRepository;
use Doctrine\ORM\Mapping as ORM;
 
#[ORM\Entity(repositoryClass: IngredientRepository::class)]
class Ingredient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
 
    #[ORM\Column(length: 255)]
    private ?string $description = null;
 
    #[ORM\ManyToOne(inversedBy: 'ingredients')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?Recette $recette = null;
 
    public function getId(): ?int
    {
        return $this->id;
    }
 
    public function getDescription(): ?string
    {
        return $this->description;
    }
 
    public function setDescription(string $description): static
    {
        $this->description = $description;
 
        return $this;
    }
 
    public function getRecette(): ?Recette
    {
        return $this->recette;
    }
 
    public function setRecette(?Recette $recette): static
    {
        $this->recette = $recette;
 
        return $this;
    }
 
    public function __toString(): string
    {
        return (string) $this->description;
    }
}
 
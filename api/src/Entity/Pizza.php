<?php

namespace App\Entity;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Repository\PizzaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Gedmo\Mapping\Annotation as Gedmo;


#[ApiResource()]
#[Get(
    normalizationContext: [
        'groups' => ['pizza_get'],
    ],
)]
#[GetCollection]
#[Post(
    denormalizationContext: [
        'groups' => ['pizza_write'],
    ],
    normalizationContext: [
        'groups' => ['pizza_get'],
    ],
)]
#[Patch(
    denormalizationContext: [
        'groups' => ['pizza_write'],
    ],
    normalizationContext: [
        'groups' => ['pizza_get'],
    ],
    security: 'is_granted("ROLE_USER")',
)]
#[ORM\Entity(repositoryClass: PizzaRepository::class)]
class Pizza
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['pizza_get', 'ingredient_get', 'pizza_write'])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(['pizza_write'])]
    private ?string $description = null;

    #[Groups(['pizza_get'])]
    #[ORM\ManyToMany(targetEntity: Ingredient::class, mappedBy: 'pizza')]
    private Collection $ingredients;

    #[ORM\OneToMany(mappedBy: 'pizza', targetEntity: Detail::class)]
    private Collection $details;

    #[ORM\ManyToOne]
    #[Gedmo\Blameable(on: 'create')]
    private ?User $owner = null;

    public function __construct()
    {
        $this->ingredients = new ArrayCollection();
        $this->details = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Ingredient>
     */
    public function getIngredients(): Collection
    {
        return $this->ingredients;
    }

    public function addIngredient(Ingredient $ingredient): self
    {
        if (!$this->ingredients->contains($ingredient)) {
            $this->ingredients[] = $ingredient;
            $ingredient->addPizza($this);
        }

        return $this;
    }

    public function removeIngredient(Ingredient $ingredient): self
    {
        if ($this->ingredients->removeElement($ingredient)) {
            $ingredient->removePizza($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Detail>
     */
    public function getDetails(): Collection
    {
        return $this->details;
    }

    public function addDetail(Detail $detail): self
    {
        if (!$this->details->contains($detail)) {
            $this->details[] = $detail;
            $detail->setPizza($this);
        }

        return $this;
    }

    public function removeDetail(Detail $detail): self
    {
        if ($this->details->removeElement($detail)) {
            // set the owning side to null (unless already changed)
            if ($detail->getPizza() === $this) {
                $detail->setPizza(null);
            }
        }

        return $this;
    }
}

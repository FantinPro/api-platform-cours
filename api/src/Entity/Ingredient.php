<?php

namespace App\Entity;

use ApiPlatform\Metadata\Get;
use App\Repository\IngredientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource()]
#[Get(
    normalizationContext: [
        'groups' => ['Default', 'ingredient_get'],
    ],
)]
#[ORM\Entity(repositoryClass: IngredientRepository::class)]
class Ingredient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;


    #[ORM\Column(length: 255)]
    #[Groups(['pizza_get', 'ingredient_get'])]
    private ?string $name = null;


    #[ORM\ManyToMany(targetEntity: Pizza::class, inversedBy: 'ingredients')]
    private Collection $pizza;

    public function __construct()
    {
        $this->pizza = new ArrayCollection();
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

    /**
     * @return Collection<int, Pizza>
     */
    public function getPizza(): Collection
    {
        return $this->pizza;
    }

    public function addPizza(Pizza $pizza): self
    {
        if (!$this->pizza->contains($pizza)) {
            $this->pizza[] = $pizza;
        }

        return $this;
    }

    public function removePizza(Pizza $pizza): self
    {
        $this->pizza->removeElement($pizza);

        return $this;
    }
}

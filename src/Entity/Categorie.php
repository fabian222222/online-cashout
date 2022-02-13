<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CategorieRepository::class)]
#[ApiResource(
    collectionOperations:[
        "get",
        "post"
    ],
    itemOperations:[
        "get",
        "delete",
        "put"
    ],
    denormalizationContext: ['groups' => ['categorie:write']],
    normalizationContext: ['groups' => ['categorie:read']]
)]
class Categorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["categorie:read"])]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["categorie:read", "categorie:write"])]
    private $name;

    #[ORM\Column(type: 'datetime_immutable')]
    #[Groups(["categorie:read", "categorie:write"])]
    private $createdAt;

    #[ORM\OneToMany(mappedBy: 'Categorie', orphanRemoval:true, targetEntity: ProductHasCategorie::class)]
    #[Groups(["categorie:read", "categorie:write"])]
    private $productHasCategories;

    public function __construct()
    {
        $this->productHasCategories = new ArrayCollection();
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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection|ProductHasCategorie[]
     */
    public function getProductHasCategories(): Collection
    {
        return $this->productHasCategories;
    }

    public function addProductHasCategory(ProductHasCategorie $productHasCategory): self
    {
        if (!$this->productHasCategories->contains($productHasCategory)) {
            $this->productHasCategories[] = $productHasCategory;
            $productHasCategory->setCategorie($this);
        }

        return $this;
    }

    public function removeProductHasCategory(ProductHasCategorie $productHasCategory): self
    {
        if ($this->productHasCategories->removeElement($productHasCategory)) {
            // set the owning side to null (unless already changed)
            if ($productHasCategory->getCategorie() === $this) {
                $productHasCategory->setCategorie(null);
            }
        }

        return $this;
    }

}

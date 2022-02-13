<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ProductHasCategorieRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ProductHasCategorieRepository::class)]
#[ApiResource(
    collectionOperations:[
        "post",
        "get"
    ], 
    itemOperations:[
        "get",
        "put",
        "delete"
    ],
    denormalizationContext: ['groups' => ['productCategorie:write']],
    normalizationContext: ['groups' => ['productCategorie:read']]
)]
class ProductHasCategorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["productCategorie:read"])]
    private $id;

    #[ORM\ManyToOne(targetEntity: Product::class, inversedBy: 'productHasCategories')]
    #[Groups(["productCategorie:read", "productCategorie:write"])]
    private $Product;

    #[ORM\ManyToOne(targetEntity: Categorie::class, inversedBy: 'productHasCategories')]
    #[Groups(["productCategorie:read", "productCategorie:write"])]
    private $Categorie;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduct(): ?Product
    {
        return $this->Product;
    }

    public function setProduct(?Product $Product): self
    {
        $this->Product = $Product;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->Categorie;
    }

    public function setCategorie(?Categorie $Categorie): self
    {
        $this->Categorie = $Categorie;

        return $this;
    }
}

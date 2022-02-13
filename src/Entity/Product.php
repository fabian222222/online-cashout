<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;
use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
/**
 * @Vich\Uploadable
*/
#[ApiResource(
    collectionOperations:[
        "get",
        "post" => [
            'input_formats' => [
                'multipart' => ['multipart/form-data'],
            ],
        ]
    ], 
    itemOperations:[
        "put",
        "get", 
        "delete"
    ],
    denormalizationContext: ['groups' => ['product:write']],
    normalizationContext: ['groups' => ['product:read']]
)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["product:read"])]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["product:read", "product:write"])]
    private $name;

    /**
     * @Vich\UploadableField(mapping="media_object", fileNameProperty="filePath")
     */
    #[Groups(["product:write"])]
    public ?File $file = null;

    #[ORM\Column(nullable: true)]
    #[Groups(["product:read", "product:write"])]
    public ?string $filePath = null;

    #[ORM\Column(type: 'string')]
    #[Groups(["product:read", "product:write"])]
    private $price;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: UserHasProduct::class)]
    #[Groups(["product:read", "product:write"])]
    private $userHasProducts;

    #[ORM\OneToMany(mappedBy: 'Product', targetEntity: ProductHasCategorie::class)]
    #[Groups(["product:read", "product:write"])]
    private $productHasCategories;

    public function __construct()
    {
        $this->userHasProducts = new ArrayCollection();
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

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Collection|UserHasProduct[]
     */
    public function getUserHasProducts(): Collection
    {
        return $this->userHasProducts;
    }

    public function addUserHasProduct(UserHasProduct $userHasProduct): self
    {
        if (!$this->userHasProducts->contains($userHasProduct)) {
            $this->userHasProducts[] = $userHasProduct;
            $userHasProduct->setProduct($this);
        }

        return $this;
    }

    public function removeUserHasProduct(UserHasProduct $userHasProduct): self
    {
        if ($this->userHasProducts->removeElement($userHasProduct)) {
            // set the owning side to null (unless already changed)
            if ($userHasProduct->getProduct() === $this) {
                $userHasProduct->setProduct(null);
            }
        }

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
            $productHasCategory->setProduct($this);
        }

        return $this;
    }

    public function removeProductHasCategory(ProductHasCategorie $productHasCategory): self
    {
        if ($this->productHasCategories->removeElement($productHasCategory)) {
            // set the owning side to null (unless already changed)
            if ($productHasCategory->getProduct() === $this) {
                $productHasCategory->setProduct(null);
            }
        }

        return $this;
    }
}

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
        ],
    ], 
    itemOperations:[
        "put",
        "get", 
        "delete"
    ]
)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    /**
     * @Vich\UploadableField(mapping="media_object", fileNameProperty="filePath")
     */
    public ?File $file = null;

    #[ORM\Column(nullable: true)]
    public ?string $filePath = null;

    #[ORM\Column(type: 'string')]
    private $price;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: UserHasProduct::class)]
    private $userHasProducts;

    public function __construct()
    {
        $this->userHasProducts = new ArrayCollection();
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
}

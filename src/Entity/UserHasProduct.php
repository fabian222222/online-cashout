<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UserHasProductRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: UserHasProductRepository::class)]
#[ApiResource(
    collectionOperations:[
        "post",
        "get"
    ], 
    itemOperations:[
        "get"
    ],
    denormalizationContext: ['groups' => ['userProduct:write']],
    normalizationContext: ['groups' => ['userProduct:read']]
)]
class UserHasProduct
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["userProduct:read"])]
    private $id;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'userHasProducts')]
    #[Groups(["userProduct:read", "userProduct:write"])]
    private $user;

    #[ORM\ManyToOne(targetEntity: Product::class, inversedBy: 'userHasProducts')]
    #[Groups(["userProduct:read", "userProduct:write"])]
    private $product;

    #[ORM\Column(type: 'datetime_immutable')]
    #[Groups(["userProduct:read", "userProduct:write"])]
    private $createdAt;

    #[ORM\ManyToOne(targetEntity: PromotionCode::class, inversedBy: 'userHasProducts')]
    #[Groups(["userProduct:read", "userProduct:write"])]
    private $promotion;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

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

    public function getPromotion(): ?PromotionCode
    {
        return $this->promotion;
    }

    public function setPromotion(?PromotionCode $promotion): self
    {
        $this->promotion = $promotion;

        return $this;
    }
}

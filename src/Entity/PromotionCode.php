<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\PromotionCodeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PromotionCodeRepository::class)]
#[ApiResource(
    collectionOperations:[
        "post"
    ], 
    itemOperations:[
        "get"
    ],
    denormalizationContext: ['groups' => ['promoCode:write']],
    normalizationContext: ['groups' => ['promoCode:read']]
)]
class PromotionCode
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[Groupes(["promoCode:read"])]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groupes(["promoCode:read", "promoCode:write"])]
    private $serial;

    #[ORM\Column(type: 'boolean')]
    #[Groupes(["promoCode:read", "promoCode:write"])]
    private $pourcent;

    #[ORM\Column(type: 'boolean')]
    #[Groupes(["promoCode:read", "promoCode:write"])]
    private $fixed;

    #[ORM\Column(type: 'float')]
    #[Groupes(["promoCode:read", "promoCode:write"])]
    private $amount;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groupes(["promoCode:read", "promoCode:write"])]
    private $description;

    #[ORM\OneToMany(mappedBy: 'promotion', targetEntity: UserHasProduct::class)]
    #[Groupes(["promoCode:read", "promoCode:write"])]
    private $userHasProducts;

    #[ORM\OneToMany(mappedBy: 'promotion', targetEntity: Invoice::class)]
    #[Groupes(["promoCode:read", "promoCode:write"])]
    private $invoices;

    public function __construct()
    {
        $this->userHasProducts = new ArrayCollection();
        $this->invoices = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSerial(): ?string
    {
        return $this->serial;
    }

    public function setSerial(string $serial): self
    {
        $this->serial = $serial;

        return $this;
    }

    public function getPourcent(): ?bool
    {
        return $this->pourcent;
    }

    public function setPourcent(bool $pourcent): self
    {
        $this->pourcent = $pourcent;

        return $this;
    }

    public function getFixed(): ?bool
    {
        return $this->fixed;
    }

    public function setFixed(bool $fixed): self
    {
        $this->fixed = $fixed;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

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
            $userHasProduct->setPromotion($this);
        }

        return $this;
    }

    public function removeUserHasProduct(UserHasProduct $userHasProduct): self
    {
        if ($this->userHasProducts->removeElement($userHasProduct)) {
            // set the owning side to null (unless already changed)
            if ($userHasProduct->getPromotion() === $this) {
                $userHasProduct->setPromotion(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Invoice[]
     */
    public function getInvoices(): Collection
    {
        return $this->invoices;
    }

    public function addInvoice(Invoice $invoice): self
    {
        if (!$this->invoices->contains($invoice)) {
            $this->invoices[] = $invoice;
            $invoice->setPromotion($this);
        }

        return $this;
    }

    public function removeInvoice(Invoice $invoice): self
    {
        if ($this->invoices->removeElement($invoice)) {
            // set the owning side to null (unless already changed)
            if ($invoice->getPromotion() === $this) {
                $invoice->setPromotion(null);
            }
        }

        return $this;
    }
}

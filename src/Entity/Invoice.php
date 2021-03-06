<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\InvoiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


#[ORM\Entity(repositoryClass: InvoiceRepository::class)]
#[ApiResource(
    collectionOperations:[
        "get",
        "post"
    ],
    itemOperations:[
        "get"
    ],
    denormalizationContext: ['groups' => ['invoice:write']],
    normalizationContext: ['groups' => ['invoice:read']]
)]
class Invoice
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["invoice:read"])]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["invoice:read", "invoice:write"])]
    private $serial;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'invoices')]
    #[Groups(["invoice:read", "invoice:write"])]
    private $user;

    #[ORM\ManyToOne(targetEntity: PromotionCode::class, inversedBy: 'invoices')]
    #[Groups(["invoice:read", "invoice:write"])]
    private $promotion;

    #[ORM\Column(type: 'float')]
    #[Groups(["invoice:read", "invoice:write"])]
    private $amount;

    #[ORM\Column(type: 'datetime_immutable')]
    #[Groups(["invoice:read", "invoice:write"])]
    private $createdAt;

    #[ORM\OneToMany(mappedBy: 'invoice', targetEntity: InvoiceProduct::class)]
    #[Groups(["invoice:read", "invoice:write"])]
    private $invoiceProducts;

    public function __construct()
    {
        $this->invoiceProducts = new ArrayCollection();
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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

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

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

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
     * @return Collection|InvoiceProduct[]
     */
    public function getInvoiceProducts(): Collection
    {
        return $this->invoiceProducts;
    }

    public function addInvoiceProduct(InvoiceProduct $invoiceProduct): self
    {
        if (!$this->invoiceProducts->contains($invoiceProduct)) {
            $this->invoiceProducts[] = $invoiceProduct;
            $invoiceProduct->setInvoice($this);
        }

        return $this;
    }

    public function removeInvoiceProduct(InvoiceProduct $invoiceProduct): self
    {
        if ($this->invoiceProducts->removeElement($invoiceProduct)) {
            // set the owning side to null (unless already changed)
            if ($invoiceProduct->getInvoice() === $this) {
                $invoiceProduct->setInvoice(null);
            }
        }

        return $this;
    }
}

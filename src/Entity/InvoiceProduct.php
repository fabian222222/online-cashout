<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\InvoiceProductRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: InvoiceProductRepository::class)]
#[ApiResource(
    collectionOperations:[
        "get",
        "post"
    ], 
    itemOperations:[
        "get"
    ],
    denormalizationContext: ['groups' => ['invoiceProduct:write']],
    normalizationContext: ['groups' => ['invoiceProduct:read']]
)]
class InvoiceProduct
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["invoiceProduct:read"])]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["invoiceProduct:read", "invoiceProduct:write"])]
    private $name;

    #[ORM\Column(type: 'integer')]
    #[Groups(["invoiceProduct:read", "invoiceProduct:write"])]
    private $quantity;

    #[ORM\Column(type: 'float')]
    #[Groups(["invoiceProduct:read", "invoiceProduct:write"])]
    private $price;

    #[ORM\ManyToOne(targetEntity: Invoice::class, inversedBy: 'invoiceProducts')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["invoiceProduct:read", "invoiceProduct:write"])]
    private $invoice;

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

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getInvoice(): ?Invoice
    {
        return $this->invoice;
    }

    public function setInvoice(?Invoice $invoice): self
    {
        $this->invoice = $invoice;

        return $this;
    }
}

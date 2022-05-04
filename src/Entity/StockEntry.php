<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\StockEntryRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: StockEntryRepository::class)]
#[ORM\Table(name: 'stock_to_product')]
#[ApiResource]
class StockEntry
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'id_detail', type: 'integer')]
    private int $id;

    #[ORM\ManyToOne(targetEntity: Stock::class)]
    #[ORM\JoinColumn(name: 'id_stock', referencedColumnName: 'id_stock')]
    #[Assert\NotNull]
    private Stock $stock;

    #[ORM\ManyToOne(targetEntity: Product::class)]
    #[ORM\JoinColumn(name: 'id_produit', referencedColumnName: 'id_produit')]
    #[Assert\NotNull]
    private Product $product;

    #[ORM\Column(name: 'quantite', type: 'integer')]
    #[Assert\Positive]
    private int $quantity = 1;

    #[ORM\Column(name: 'quantite_vendue', type: 'integer')]
    #[Assert\PositiveOrZero]
    private int $soldQuantity = 0;

    #[ORM\Column(name: 'prix_achat', type: 'float')]
    #[Assert\PositiveOrZero]
    private float $buyPrice = 0.;

    public function getId(): int
    {
        return $this->id;
    }


    public function getStock(): Stock
    {
        return $this->stock;
    }


    public function setStock(Stock $stock): self
    {
        $this->stock = $stock;
        return $this;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function setProduct(Product $product): self
    {
        $this->product = $product;
        return $this;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }


    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;
        return $this;
    }

    public function getSoldQuantity(): int
    {
        return $this->soldQuantity;
    }

    public function setSoldQuantity(int $soldQuantity): self
    {
        $this->soldQuantity = $soldQuantity;
        return $this;
    }

    public function getBuyPrice(): float
    {
        return $this->buyPrice;
    }

    public function setBuyPrice(float $buyPrice): self
    {
        $this->buyPrice = $buyPrice;
        return $this;
    }
}

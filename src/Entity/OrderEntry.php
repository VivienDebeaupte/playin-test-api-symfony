<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\OrderEntryRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: OrderEntryRepository::class)]
#[ORM\Table(name: 't_id_panier_id_produit')]
#[ApiResource]
class OrderEntry
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'id_detail', type: 'integer')]
    private int $id;

    #[ORM\ManyToOne(targetEntity: Order::class)]
    #[ORM\JoinColumn(name: 'id_panier', referencedColumnName: 'id_panier')]
    #[Assert\NotNull]
    private Order $order;

    #[ORM\ManyToOne(targetEntity: Product::class)]
    #[ORM\JoinColumn(name: 'id_produit', referencedColumnName: 'id_produit')]
    #[Assert\NotNull]
    private Product $product;

    #[ORM\Column(name: 'quantite', type: 'integer')]
    #[Assert\Positive]
    private int $quantity = 1;

    #[ORM\Column(name: 'prix_vente', type: 'float')]
    #[Assert\PositiveOrZero]
    private float $sellPrice = 0.;

    public function getId(): int
    {
        return $this->id;
    }


    public function getOrder(): Order
    {
        return $this->order;
    }


    public function setOrder(Order $order): self
    {
        $this->order = $order;
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

    public function getSellPrice(): float
    {
        return $this->sellPrice;
    }

    public function setSellPrice(float $sellPrice): self
    {
        $this->sellPrice = $sellPrice;
        return $this;
    }
}

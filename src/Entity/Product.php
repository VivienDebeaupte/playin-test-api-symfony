<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\PositiveOrZero;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ORM\Table(name: 't_produit')]
#[ApiResource]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'id_produit', type: 'integer')]
    private int $id;

    #[ORM\Column(name: 'nom', type: 'string', length: 150)]
    #[NotBlank]
    private string $name;

    #[ORM\Column(name: 'prix_vente', type: 'float')]
    #[NotNull]
    #[PositiveOrZero]
    private float $sellPrice = 0.;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: 'StockEntry')]
    private $stockEntry;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: 'DepositEntry')]
    private $depositEntry;

    public function __construct() {
        $this->stockEntry   = new ArrayCollection();
        $this->depositEntry = new ArrayCollection();
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

    public function getSellPrice(): ?float
    {
        return $this->sellPrice;
    }

    public function setSellPrice(float $sellPrice): self
    {
        $this->sellPrice = $sellPrice;

        return $this;
    }

    public function getStockEntry(): Collection
    {
        return $this->stockEntry;
    }

    public function getDepositEntry(): Collection
    {
        return $this->depositEntry;
    }
}

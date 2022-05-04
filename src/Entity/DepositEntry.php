<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\DepositEntryRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: DepositEntryRepository::class)]
#[ORM\Table(name: 't_id_depot_id_produit')]
#[ApiResource]
class DepositEntry
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'id_detail', type: 'integer')]
    private int $id;

    #[ORM\ManyToOne(targetEntity: Deposit::class)]
    #[ORM\JoinColumn(name: 'id_depot', referencedColumnName: 'id_depot')]
    #[Assert\NotNull]
    private Deposit $deposit;

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

    #[ORM\Column(name: 'pourcentage', type: 'integer')]
    #[Assert\Range(min: 0, max: 100)]
    private int $reimbursementPercentage = 70;

    public function getId(): int
    {
        return $this->id;
    }


    public function getDeposit(): Deposit
    {
        return $this->deposit;
    }


    public function setDeposit(Deposit $deposit): self
    {
        $this->deposit = $deposit;
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


    public function getReimbursementPercentage(): int
    {
        return $this->reimbursementPercentage;
    }


    public function setReimbursementPercentage(int $reimbursementPercentage): self
    {
        $this->reimbursementPercentage = $reimbursementPercentage;
        return $this;
    }
}

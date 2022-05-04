<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\AssociationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AssociationRepository::class)]
#[ORM\Table(name: 't_assoc')]
#[ApiResource(
    collectionOperations: ['get'],
    itemOperations: []
)]
class Association
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'id_assoc', type: 'integer', nullable: 'false')]
    private int $id;

    #[ORM\Column(name: 'vendeur', type: 'string', length: '0', nullable: 'true')]
    private ?string $vendeur;

    #[ORM\Column(name: 'id_detail', type: 'integer', nullable: 'true')]
    private ?int $idDetail;

    #[ORM\Column(name: 'id_detail_stock', type: 'integer', nullable: 'true')]
    private ?int $idDetailStock;

    #[ORM\Column(name: 'quantite', type: 'integer', nullable: 'false')]
    private int $quantite = 1;

    #[ORM\Column(name: 'marge', type: 'float', nullable: 'false')]
    private float $marge = 0.000;

    public function __construct($vendeur, $id_detail, $id_detail_stock, $quantity=1, $marge=0) {
        $this->vendeur       = $vendeur;
        $this->idDetail      = $id_detail;
        $this->idDetailStock = $id_detail_stock;
        $this->quantite      = $quantity;
        $this->marge         = $marge;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVendeur(): ?string
    {
        return $this->vendeur;
    }

    public function setVendeur(?string $vendeur): self
    {
        $this->vendeur = $vendeur;

        return $this;
    }

    public function getIdDetail(): ?int
    {
        return $this->idDetail;
    }

    public function setIdDetail(?int $idDetail): self
    {
        $this->idDetail = $idDetail;

        return $this;
    }

    public function getIdDetailStock(): ?int
    {
        return $this->idDetailStock;
    }

    public function setIdDetailStock(?int $idDetailStock): self
    {
        $this->idDetailStock = $idDetailStock;

        return $this;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }


}

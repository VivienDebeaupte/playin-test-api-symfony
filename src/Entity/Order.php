<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\Api\OrderSetValidateController;
use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: 't_panier')]
#[ApiResource(
    collectionOperations: [],
    itemOperations: [
    'get',
    'patch' => [
        'controller' => OrderSetValidateController::class,
    ],
    'put' => [
        'controller' => OrderSetValidateController::class,
    ]
])]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'id_panier', type: 'integer')]
    private int $id;

    #[ORM\Column(name: 'valide', type: 'boolean')]
    private bool $validated = false;

    #[ORM\OneToMany(mappedBy: 'order', targetEntity: 'OrderEntry')]
    private $orderEntry;

    public function __construct() {
        $this->orderEntry = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isValidated(): bool
    {
        return $this->validated;
    }

    public function setValidated(bool $validated): self
    {
        $this->validated = $validated;
        return $this;
    }

    public function getOrderEntry(): Collection
    {
        return $this->orderEntry;
    }
}

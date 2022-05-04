<?php

namespace App\Controller\Api;

use App\Entity\Association;
use App\Entity\Order;
use App\Repository\AssociationRepository;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class OrderSetValidateController extends AbstractController
{
    private AssociationRepository $associationRepository;

    public function __construct(AssociationRepository $associationRepository)
    {
        $this->associationRepository = $associationRepository;
    }

    public function __invoke(Order $data): Order
    {
        foreach ($data->getOrderEntry() as $orderEntry) {

            $alreadyExist = $this->associationRepository->findOneBy(['idDetail' => $orderEntry->getId()]);
            if(!$alreadyExist) {
                $product   = $orderEntry->getProduct();
                $quantity  = $orderEntry->getQuantity();
                $sellPrice = $orderEntry->getSellPrice();

                $case = 1;
                while($quantity > 0) {
                    if($case === 1) {
                        foreach ($product->getDepositEntry() as $depositEntry) {
                            if($depositEntry->getQuantity() > 0) {
                                $total = 0;
                                while ($depositEntry->getQuantity() > 0 && $quantity > 0) {
                                    $depositEntry->setQuantity($depositEntry->getQuantity() - 1)
                                        ->setSoldQuantity($depositEntry->getSoldQuantity() + 1);
                                    $quantity -= 1;
                                    $total++;
                                }
                                $marge = $sellPrice - ( $sellPrice * ($depositEntry->getReimbursementPercentage()/100) );
                                $this->associationRepository->add(new Association("N", $orderEntry->getId(), $depositEntry->getId(), $total, $marge));
                            }
                        }
                        $case = 2;
                    }
                    else if($case === 2) {

                        foreach ($product->getStockEntry() as $stockEntry) {
                            if($stockEntry->getQuantity() > 0) {
                                $total = 0;
                                while ($stockEntry->getQuantity() > 0 && $quantity > 0) {
                                    $stockEntry->setQuantity($stockEntry->getQuantity() - 1)
                                        ->setSoldQuantity($stockEntry->getSoldQuantity() + 1);
                                    $quantity -= 1;
                                    $total++;
                                }
                                $marge = $sellPrice - $stockEntry->getBuyPrice();
                                $this->associationRepository->add(new Association("O", $orderEntry->getId(), $stockEntry->getId(), $total, $marge));
                            }
                        }
                        $case = 0;
                    }
                    else {
                        $this->associationRepository->add(new Association("N", $orderEntry->getId(), null, $quantity));
                        break;
                    }
                }
            }
        }

        return $data;
    }
}

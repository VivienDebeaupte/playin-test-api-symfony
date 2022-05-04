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
        // On parcourt les entrées de la commande
        foreach ($data->getOrderEntry() as $orderEntry) {

            // On vérifie pour chaque entrée si l'association n'a pas été créée, si c'est le cas on ne fait rien
            $alreadyExist = $this->associationRepository->findOneBy(['idDetail' => $orderEntry->getId()]);

            if(!$alreadyExist) {
                $product   = $orderEntry->getProduct();
                $quantity  = $orderEntry->getQuantity();
                $sellPrice = $orderEntry->getSellPrice();


                $case = 1;
                // Tant que les quantités de l'entrée de la commande ne sont pas complètes, on poursuit l'opération
                while($quantity > 0) {
                    /*
                     * cas n°1 on parcourt les dépôts, vérifier si nous avons les quantités du produit.
                     * Ici nous commençons toujours par vérifier les dêpots en premier
                     */
                    if($case === 1) {
                        // On parcourt tous les dêpots où notre produit est présent
                        foreach ($product->getDepositEntry() as $depositEntry) {
                            // Si il reste une quantité supérieur à zero dans ce dépôt
                            if($depositEntry->getQuantity() > 0) {
                                $total = 0;

                                /* Tant que les quantités du produit dans le dépôt et que la quantité du produit
                                 * de notre commande, sont supérieur à zéro, on boucle
                                 */
                                while ($depositEntry->getQuantity() > 0 && $quantity > 0) {
                                    // On décrémente la quantité et on incrémente la quantité vendue du produit
                                    // dans le dépôt
                                    $depositEntry->setQuantity($depositEntry->getQuantity() - 1)
                                        ->setSoldQuantity($depositEntry->getSoldQuantity() + 1);
                                    // On décrémente la quantité du produit de la commande
                                    $quantity -= 1;
                                    // On compte la quantité du produit pour notre Association
                                    $total++;
                                }
                                // On calcule la marge faîte sur la vente du produit dans ce dépôt
                                $marge = $sellPrice - ( $sellPrice * ($depositEntry->getReimbursementPercentage()/100) );
                                // On insère une entrée dans la table Association (t_assoc) avec toutes les
                                // informations requises, en précisant la propriété vendeur à N
                                $this->associationRepository->add(
                                    new Association(
                                        "N",
                                        $orderEntry->getId(),
                                        $depositEntry->getId(),
                                        $total,
                                        $marge
                                    )
                                );
                            }
                        }
                        // On considère qu'il n'y a plus de quantité dans tous les dépôts, on passe $case à 2 pour
                        // parcourir les stocks
                        $case = 2;
                    }
                    // cas n°2 on parcourt les stocks, vérifier si nous avons les quantités du produit.
                    else if($case === 2) {
                        // On parcourt tous les stocks où notre produit est présent
                        foreach ($product->getStockEntry() as $stockEntry) {
                            // Si il reste une quantité supérieur à zero dans ce stock
                            if($stockEntry->getQuantity() > 0) {
                                $total = 0;

                                /* Tant que les quantités du produit dans le stock et que la quantité du produit
                                 * de notre commande, sont supérieur à zéro, on boucle
                                 */
                                while ($stockEntry->getQuantity() > 0 && $quantity > 0) {
                                    // On décrémente la quantité et on incrémente la quantité vendue du produit
                                    // dans le stock
                                    $stockEntry->setQuantity($stockEntry->getQuantity() - 1)
                                        ->setSoldQuantity($stockEntry->getSoldQuantity() + 1);
                                    // On décrémente la quantité du produit de la commande
                                    $quantity -= 1;
                                    // On compte la quantité du produit pour notre Association
                                    $total++;
                                }
                                // On calcule la marge faîte sur la vente du produit dans ce stock
                                $marge = $sellPrice - $stockEntry->getBuyPrice();
                                // On insère une entrée dans la table Association (t_assoc) avec toutes les
                                // informations requises, en précisant la propriété vendeur à O
                                $this->associationRepository->add(
                                    new Association(
                                        "O",
                                        $orderEntry->getId(),
                                        $stockEntry->getId(),
                                        $total,
                                        $marge
                                    )
                                );
                            }
                        }
                        // On considère qu'il n'y a plus de quantité dans tous les stocks, on passe $case à 0, on
                        // considère qu'il n'y a plus de quantité du produit ni dans les dépôts, ni dans les stocks
                        $case = 0;
                    }
                    // cas n°0 il n'y a plus de quantité ni dans les dépôts, ni les stocks
                    else {
                        // On insère une entrée dans la table Association (t_assoc) avec toutes les
                        // informations requises, en précisant la propriété vendeur à V
                        $this->associationRepository->add(
                            new Association(
                                "V", $orderEntry->getId(), null, $quantity
                            )
                        );
                        break;
                    }
                }
            }
        }

        return $data;
    }
}

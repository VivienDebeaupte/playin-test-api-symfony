<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220504000157 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE stock CHANGE valide valide TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE stock_to_product DROP FOREIGN KEY stock_to_product_ibfk_1');
        $this->addSql('ALTER TABLE stock_to_product DROP FOREIGN KEY stock_to_product_ibfk_2');
        $this->addSql('ALTER TABLE stock_to_product CHANGE id_stock id_stock INT DEFAULT NULL, CHANGE id_produit id_produit INT DEFAULT NULL, CHANGE quantite quantite INT NOT NULL, CHANGE quantite_vendue quantite_vendue INT NOT NULL, CHANGE prix_achat prix_achat DOUBLE PRECISION NOT NULL');
        $this->addSql('DROP INDEX id_stock ON stock_to_product');
        $this->addSql('CREATE INDEX IDX_F39BCEF4A5B31750 ON stock_to_product (id_stock)');
        $this->addSql('DROP INDEX id_produit ON stock_to_product');
        $this->addSql('CREATE INDEX IDX_F39BCEF4F7384557 ON stock_to_product (id_produit)');
        $this->addSql('ALTER TABLE stock_to_product ADD CONSTRAINT stock_to_product_ibfk_1 FOREIGN KEY (id_stock) REFERENCES stock (id_stock)');
        $this->addSql('ALTER TABLE stock_to_product ADD CONSTRAINT stock_to_product_ibfk_2 FOREIGN KEY (id_produit) REFERENCES t_produit (id_produit)');
        $this->addSql('ALTER TABLE t_assoc ADD marge DOUBLE PRECISION DEFAULT NULL, CHANGE quantite quantite INT DEFAULT NULL');
        $this->addSql('ALTER TABLE t_depot CHANGE valide valide TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE t_id_depot_id_produit DROP FOREIGN KEY t_id_depot_id_produit_ibfk_1');
        $this->addSql('ALTER TABLE t_id_depot_id_produit DROP FOREIGN KEY t_id_depot_id_produit_ibfk_2');
        $this->addSql('ALTER TABLE t_id_depot_id_produit CHANGE id_depot id_depot INT DEFAULT NULL, CHANGE id_produit id_produit INT DEFAULT NULL, CHANGE quantite quantite INT NOT NULL, CHANGE quantite_vendue quantite_vendue INT NOT NULL, CHANGE pourcentage pourcentage INT NOT NULL');
        $this->addSql('DROP INDEX id_depot ON t_id_depot_id_produit');
        $this->addSql('CREATE INDEX IDX_80352F02A911CA8C ON t_id_depot_id_produit (id_depot)');
        $this->addSql('DROP INDEX id_produit ON t_id_depot_id_produit');
        $this->addSql('CREATE INDEX IDX_80352F02F7384557 ON t_id_depot_id_produit (id_produit)');
        $this->addSql('ALTER TABLE t_id_depot_id_produit ADD CONSTRAINT t_id_depot_id_produit_ibfk_1 FOREIGN KEY (id_depot) REFERENCES t_depot (id_depot)');
        $this->addSql('ALTER TABLE t_id_depot_id_produit ADD CONSTRAINT t_id_depot_id_produit_ibfk_2 FOREIGN KEY (id_produit) REFERENCES t_produit (id_produit)');
        $this->addSql('ALTER TABLE t_id_panier_id_produit DROP FOREIGN KEY t_id_panier_id_produit_ibfk_1');
        $this->addSql('ALTER TABLE t_id_panier_id_produit DROP FOREIGN KEY t_id_panier_id_produit_ibfk_2');
        $this->addSql('ALTER TABLE t_id_panier_id_produit CHANGE id_panier id_panier INT DEFAULT NULL, CHANGE id_produit id_produit INT DEFAULT NULL, CHANGE quantite quantite INT NOT NULL, CHANGE prix_vente prix_vente DOUBLE PRECISION NOT NULL');
        $this->addSql('DROP INDEX id_panier ON t_id_panier_id_produit');
        $this->addSql('CREATE INDEX IDX_81B186CE2FBB81F ON t_id_panier_id_produit (id_panier)');
        $this->addSql('DROP INDEX id_produit ON t_id_panier_id_produit');
        $this->addSql('CREATE INDEX IDX_81B186CEF7384557 ON t_id_panier_id_produit (id_produit)');
        $this->addSql('ALTER TABLE t_id_panier_id_produit ADD CONSTRAINT t_id_panier_id_produit_ibfk_1 FOREIGN KEY (id_panier) REFERENCES t_panier (id_panier)');
        $this->addSql('ALTER TABLE t_id_panier_id_produit ADD CONSTRAINT t_id_panier_id_produit_ibfk_2 FOREIGN KEY (id_produit) REFERENCES t_produit (id_produit)');
        $this->addSql('ALTER TABLE t_panier CHANGE valide valide TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE t_produit CHANGE prix_vente prix_vente DOUBLE PRECISION NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE stock CHANGE valide valide TINYINT(1) DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE stock_to_product DROP FOREIGN KEY FK_F39BCEF4A5B31750');
        $this->addSql('ALTER TABLE stock_to_product DROP FOREIGN KEY FK_F39BCEF4F7384557');
        $this->addSql('ALTER TABLE stock_to_product CHANGE id_stock id_stock INT NOT NULL, CHANGE id_produit id_produit INT NOT NULL, CHANGE quantite quantite INT DEFAULT 1 NOT NULL, CHANGE quantite_vendue quantite_vendue INT DEFAULT 0 NOT NULL, CHANGE prix_achat prix_achat NUMERIC(8, 3) DEFAULT \'0.000\' NOT NULL');
        $this->addSql('DROP INDEX idx_f39bcef4a5b31750 ON stock_to_product');
        $this->addSql('CREATE INDEX id_stock ON stock_to_product (id_stock)');
        $this->addSql('DROP INDEX idx_f39bcef4f7384557 ON stock_to_product');
        $this->addSql('CREATE INDEX id_produit ON stock_to_product (id_produit)');
        $this->addSql('ALTER TABLE stock_to_product ADD CONSTRAINT FK_F39BCEF4A5B31750 FOREIGN KEY (id_stock) REFERENCES stock (id_stock)');
        $this->addSql('ALTER TABLE stock_to_product ADD CONSTRAINT FK_F39BCEF4F7384557 FOREIGN KEY (id_produit) REFERENCES t_produit (id_produit)');
        $this->addSql('ALTER TABLE t_assoc DROP marge, CHANGE vendeur vendeur VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_general_ci`, CHANGE quantite quantite INT DEFAULT 1 NOT NULL');
        $this->addSql('ALTER TABLE t_depot CHANGE valide valide TINYINT(1) DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE t_id_depot_id_produit DROP FOREIGN KEY FK_80352F02A911CA8C');
        $this->addSql('ALTER TABLE t_id_depot_id_produit DROP FOREIGN KEY FK_80352F02F7384557');
        $this->addSql('ALTER TABLE t_id_depot_id_produit CHANGE id_depot id_depot INT NOT NULL, CHANGE id_produit id_produit INT NOT NULL, CHANGE quantite quantite INT DEFAULT 1 NOT NULL, CHANGE quantite_vendue quantite_vendue INT DEFAULT 0 NOT NULL, CHANGE pourcentage pourcentage INT DEFAULT 70 NOT NULL');
        $this->addSql('DROP INDEX idx_80352f02a911ca8c ON t_id_depot_id_produit');
        $this->addSql('CREATE INDEX id_depot ON t_id_depot_id_produit (id_depot)');
        $this->addSql('DROP INDEX idx_80352f02f7384557 ON t_id_depot_id_produit');
        $this->addSql('CREATE INDEX id_produit ON t_id_depot_id_produit (id_produit)');
        $this->addSql('ALTER TABLE t_id_depot_id_produit ADD CONSTRAINT FK_80352F02A911CA8C FOREIGN KEY (id_depot) REFERENCES t_depot (id_depot)');
        $this->addSql('ALTER TABLE t_id_depot_id_produit ADD CONSTRAINT FK_80352F02F7384557 FOREIGN KEY (id_produit) REFERENCES t_produit (id_produit)');
        $this->addSql('ALTER TABLE t_id_panier_id_produit DROP FOREIGN KEY FK_81B186CE2FBB81F');
        $this->addSql('ALTER TABLE t_id_panier_id_produit DROP FOREIGN KEY FK_81B186CEF7384557');
        $this->addSql('ALTER TABLE t_id_panier_id_produit CHANGE id_panier id_panier INT NOT NULL, CHANGE id_produit id_produit INT NOT NULL, CHANGE quantite quantite INT DEFAULT 1 NOT NULL, CHANGE prix_vente prix_vente NUMERIC(8, 3) DEFAULT \'0.000\' NOT NULL');
        $this->addSql('DROP INDEX idx_81b186ce2fbb81f ON t_id_panier_id_produit');
        $this->addSql('CREATE INDEX id_panier ON t_id_panier_id_produit (id_panier)');
        $this->addSql('DROP INDEX idx_81b186cef7384557 ON t_id_panier_id_produit');
        $this->addSql('CREATE INDEX id_produit ON t_id_panier_id_produit (id_produit)');
        $this->addSql('ALTER TABLE t_id_panier_id_produit ADD CONSTRAINT FK_81B186CE2FBB81F FOREIGN KEY (id_panier) REFERENCES t_panier (id_panier)');
        $this->addSql('ALTER TABLE t_id_panier_id_produit ADD CONSTRAINT FK_81B186CEF7384557 FOREIGN KEY (id_produit) REFERENCES t_produit (id_produit)');
        $this->addSql('ALTER TABLE t_panier CHANGE valide valide TINYINT(1) DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE t_produit CHANGE nom nom VARCHAR(150) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE prix_vente prix_vente NUMERIC(8, 3) DEFAULT \'0.000\' NOT NULL');
    }
}

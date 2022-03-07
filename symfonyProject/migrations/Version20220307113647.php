<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220307113647 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categorie_e (id INT AUTO_INCREMENT NOT NULL, nom_cat_e VARCHAR(255) NOT NULL, image_e VARCHAR(255) NOT NULL, desciption VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evenement (id INT AUTO_INCREMENT NOT NULL, category_id_id INT NOT NULL, nom_e VARCHAR(25) NOT NULL, date_deb DATE NOT NULL, date_fin DATE NOT NULL, image_e VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, prix_e DOUBLE PRECISION NOT NULL, INDEX IDX_B26681E9777D11E (category_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681E9777D11E FOREIGN KEY (category_id_id) REFERENCES categorie_e (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681E9777D11E');
        $this->addSql('DROP TABLE categorie_e');
        $this->addSql('DROP TABLE evenement');
    }
}

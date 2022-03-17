<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220307182841 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categorie_t (id INT AUTO_INCREMENT NOT NULL, type_transport VARCHAR(25) NOT NULL, image_transport VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transport (id INT AUTO_INCREMENT NOT NULL, categorie_t_id INT DEFAULT NULL, lieu_depart VARCHAR(25) NOT NULL, lieu_arrivee VARCHAR(25) NOT NULL, date_dep DATE NOT NULL, date_arrivee DATE NOT NULL, heure_arrivee TIME NOT NULL, heure_depart TIME NOT NULL, date_retour DATE NOT NULL, heure_retour TIME NOT NULL, nb_place INT NOT NULL, nb_bagage INT NOT NULL, prix_t DOUBLE PRECISION NOT NULL, disponibilite TINYINT(1) NOT NULL, INDEX IDX_66AB212E2B3073A2 (categorie_t_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE transport ADD CONSTRAINT FK_66AB212E2B3073A2 FOREIGN KEY (categorie_t_id) REFERENCES categorie_t (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE transport DROP FOREIGN KEY FK_66AB212E2B3073A2');
        $this->addSql('DROP TABLE categorie_t');
        $this->addSql('DROP TABLE transport');
    }
}

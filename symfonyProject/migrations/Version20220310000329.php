<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220310000329 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande ADD utilisateur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_6EEAA67DFB88E14F ON commande (utilisateur_id)');
        $this->addSql('ALTER TABLE commande_e ADD evenement_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commande_e ADD CONSTRAINT FK_E406A93FFD02F13 FOREIGN KEY (evenement_id) REFERENCES evenement (id)');
        $this->addSql('CREATE INDEX IDX_E406A93FFD02F13 ON commande_e (evenement_id)');
        $this->addSql('ALTER TABLE materiel ADD commande_m_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE materiel ADD CONSTRAINT FK_18D2B0911A64ED03 FOREIGN KEY (commande_m_id) REFERENCES commande_m (id)');
        $this->addSql('CREATE INDEX IDX_18D2B0911A64ED03 ON materiel (commande_m_id)');
        $this->addSql('ALTER TABLE transport ADD commande_t_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE transport ADD CONSTRAINT FK_66AB212E3775F516 FOREIGN KEY (commande_t_id) REFERENCES commande_t (id)');
        $this->addSql('CREATE INDEX IDX_66AB212E3775F516 ON transport (commande_t_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DFB88E14F');
        $this->addSql('DROP INDEX IDX_6EEAA67DFB88E14F ON commande');
        $this->addSql('ALTER TABLE commande DROP utilisateur_id');
        $this->addSql('ALTER TABLE commande_e DROP FOREIGN KEY FK_E406A93FFD02F13');
        $this->addSql('DROP INDEX IDX_E406A93FFD02F13 ON commande_e');
        $this->addSql('ALTER TABLE commande_e DROP evenement_id');
        $this->addSql('ALTER TABLE materiel DROP FOREIGN KEY FK_18D2B0911A64ED03');
        $this->addSql('DROP INDEX IDX_18D2B0911A64ED03 ON materiel');
        $this->addSql('ALTER TABLE materiel DROP commande_m_id');
        $this->addSql('ALTER TABLE transport DROP FOREIGN KEY FK_66AB212E3775F516');
        $this->addSql('DROP INDEX IDX_66AB212E3775F516 ON transport');
        $this->addSql('ALTER TABLE transport DROP commande_t_id');
    }
}

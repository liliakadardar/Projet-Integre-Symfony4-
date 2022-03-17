<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220309233102 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DA68F15FA');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DE17FD84A');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DD2C5A27');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DA68F15FA FOREIGN KEY (commmande_t_c_id) REFERENCES commande_t (id)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DE17FD84A FOREIGN KEY (commande_e_c_id) REFERENCES commande_e (id)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DD2C5A27 FOREIGN KEY (commande_m_c_id) REFERENCES commande_m (id)');
        $this->addSql('ALTER TABLE evenement DROP e_c_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DE17FD84A');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DD2C5A27');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DA68F15FA');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DE17FD84A FOREIGN KEY (commande_e_c_id) REFERENCES commande_e (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DD2C5A27 FOREIGN KEY (commande_m_c_id) REFERENCES commande_m (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DA68F15FA FOREIGN KEY (commmande_t_c_id) REFERENCES commande_t (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE evenement ADD e_c_id INT NOT NULL');
    }
}

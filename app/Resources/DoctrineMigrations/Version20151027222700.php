<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20151027222700 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql("INSERT INTO configuration (slug, name, value) VALUES ('receiver_name', 'Votre organisation', '')");
        $this->addSql("INSERT INTO configuration (slug, name, value) VALUES ('receiver_address', 'Votre adresse', '')");
        $this->addSql("INSERT INTO configuration (slug, name, value) VALUES ('receiver_logo', 'URL de votre logo', '')");
        $this->addSql("INSERT INTO configuration (slug, name, value) VALUES ('receiver_subject', 'Objet de votre association', '')");
        $this->addSql("INSERT INTO configuration (slug, name, value) VALUES ('receiver_notification', 'Objet de votre association', 'Association loi 1901 déclarée en sous-préfecture de [ville] le [date]')");
        $this->addSql("INSERT INTO configuration (slug, name, value) VALUES ('receiver_number', 'Numéro de déclaration de l''organisation', '')");
        $this->addSql("INSERT INTO configuration (slug, name, value) VALUES ('receiver_siret', 'Numéro de SIRET', '')");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql("DELETE FROM configuration WHERE slug = 'receiver_name'");
        $this->addSql("DELETE FROM configuration WHERE slug = 'receiver_address'");
        $this->addSql("DELETE FROM configuration WHERE slug = 'receiver_logo'");
        $this->addSql("DELETE FROM configuration WHERE slug = 'receiver_subject'");
        $this->addSql("DELETE FROM configuration WHERE slug = 'receiver_notification'");
        $this->addSql("DELETE FROM configuration WHERE slug = 'receiver_number'");
        $this->addSql("DELETE FROM configuration WHERE slug = 'receiver_siret'");
    }
}

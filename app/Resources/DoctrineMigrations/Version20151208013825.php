<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20151208013825 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE receipt ADD payment_type_id INT UNSIGNED NOT NULL, CHANGE amount amount DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE receipt ADD CONSTRAINT FK_5399B645DC058279 FOREIGN KEY (payment_type_id) REFERENCES payment_type (id)');
        $this->addSql('CREATE INDEX IDX_5399B645DC058279 ON receipt (payment_type_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE receipt DROP FOREIGN KEY FK_5399B645DC058279');
        $this->addSql('DROP INDEX IDX_5399B645DC058279 ON receipt');
        $this->addSql('ALTER TABLE receipt DROP payment_type_id, CHANGE amount amount DOUBLE PRECISION NOT NULL');
    }
}

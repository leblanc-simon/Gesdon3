<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20151023175127 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE donation CHANGE contributor_id contributor_id INT UNSIGNED NOT NULL, CHANGE payment_type_id payment_type_id INT UNSIGNED NOT NULL, CHANGE amount amount DOUBLE PRECISION NOT NULL, CHANGE fee fee DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE contributor CHANGE contributor_type_id contributor_type_id INT UNSIGNED NOT NULL');
        $this->addSql('ALTER TABLE receipt CHANGE contributor_id contributor_id INT UNSIGNED NOT NULL, CHANGE amount amount DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE address CHANGE contributor_id contributor_id INT UNSIGNED NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE address CHANGE contributor_id contributor_id INT UNSIGNED DEFAULT NULL');
        $this->addSql('ALTER TABLE contributor CHANGE contributor_type_id contributor_type_id INT UNSIGNED DEFAULT NULL');
        $this->addSql('ALTER TABLE donation CHANGE contributor_id contributor_id INT UNSIGNED DEFAULT NULL, CHANGE payment_type_id payment_type_id INT UNSIGNED DEFAULT NULL, CHANGE amount amount DOUBLE PRECISION NOT NULL, CHANGE fee fee DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE receipt CHANGE contributor_id contributor_id INT UNSIGNED DEFAULT NULL, CHANGE amount amount DOUBLE PRECISION NOT NULL');
    }
}

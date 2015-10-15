<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20151013230350 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE donation (id INT UNSIGNED AUTO_INCREMENT NOT NULL, contributor_id INT UNSIGNED DEFAULT NULL, receipt_id INT UNSIGNED DEFAULT NULL, uuid VARCHAR(255) NOT NULL, amount DOUBLE PRECISION NOT NULL, via VARCHAR(45) NOT NULL, fee DOUBLE PRECISION NOT NULL, converted TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX fk_donation_contributor1_idx (contributor_id), INDEX fk_donation_receipt1_idx (receipt_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contributor (id INT UNSIGNED AUTO_INCREMENT NOT NULL, firstname VARCHAR(255) DEFAULT NULL, lastname VARCHAR(255) DEFAULT NULL, company VARCHAR(255) DEFAULT NULL, email VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_DA6F9793E7927C74 (email), UNIQUE INDEX email_UNIQUE (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE receipt (id INT UNSIGNED NOT NULL, legal_number INT UNSIGNED NOT NULL, email VARCHAR(255) NOT NULL, firstname VARCHAR(255) DEFAULT NULL, lastname VARCHAR(255) DEFAULT NULL, company VARCHAR(255) DEFAULT NULL, street VARCHAR(255) NOT NULL, additional VARCHAR(255) DEFAULT NULL, zip_code VARCHAR(45) NOT NULL, city VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, amount DOUBLE PRECISION NOT NULL, begin_date DATETIME NOT NULL, end_date DATETIME NOT NULL, recurring TINYINT(1) NOT NULL, sended TINYINT(1) NOT NULL, via VARCHAR(45) NOT NULL, filename VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, sended_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_5399B6457AA6C52F (legal_number), UNIQUE INDEX legal_number_UNIQUE (legal_number), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE address (id INT UNSIGNED AUTO_INCREMENT NOT NULL, contributor_id INT UNSIGNED DEFAULT NULL, street VARCHAR(255) NOT NULL, additional VARCHAR(255) DEFAULT NULL, zip_code VARCHAR(45) NOT NULL, city VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, active TINYINT(1) NOT NULL, INDEX fk_address_contributor_idx (contributor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE donation ADD CONSTRAINT FK_31E581A07A19A357 FOREIGN KEY (contributor_id) REFERENCES contributor (id)');
        $this->addSql('ALTER TABLE donation ADD CONSTRAINT FK_31E581A02B5CA896 FOREIGN KEY (receipt_id) REFERENCES receipt (id)');
        $this->addSql('ALTER TABLE address ADD CONSTRAINT FK_D4E6F817A19A357 FOREIGN KEY (contributor_id) REFERENCES contributor (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE donation DROP FOREIGN KEY FK_31E581A07A19A357');
        $this->addSql('ALTER TABLE address DROP FOREIGN KEY FK_D4E6F817A19A357');
        $this->addSql('ALTER TABLE donation DROP FOREIGN KEY FK_31E581A02B5CA896');
        $this->addSql('DROP TABLE donation');
        $this->addSql('DROP TABLE contributor');
        $this->addSql('DROP TABLE receipt');
        $this->addSql('DROP TABLE address');
    }
}

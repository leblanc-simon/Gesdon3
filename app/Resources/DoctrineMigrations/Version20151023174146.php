<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20151023174146 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE payment_type (id INT UNSIGNED AUTO_INCREMENT NOT NULL, slug VARCHAR(45) NOT NULL, name VARCHAR(45) NOT NULL, UNIQUE INDEX UNIQ_AD5DC05D989D9B62 (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE configuration (id INT UNSIGNED AUTO_INCREMENT NOT NULL, slug VARCHAR(45) NOT NULL, name VARCHAR(45) NOT NULL, value VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_A5E2A5D7989D9B62 (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contributor_type (id INT UNSIGNED AUTO_INCREMENT NOT NULL, slug VARCHAR(45) NOT NULL, name VARCHAR(45) NOT NULL, UNIQUE INDEX UNIQ_5F960267989D9B62 (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE donation DROP FOREIGN KEY FK_31E581A02B5CA896');
        $this->addSql('ALTER TABLE donation DROP FOREIGN KEY FK_31E581A07A19A357');
        $this->addSql('ALTER TABLE donation ADD payment_type_id INT UNSIGNED DEFAULT NULL, ADD reference VARCHAR(45) DEFAULT NULL, CHANGE amount amount DOUBLE PRECISION NOT NULL, CHANGE via via VARCHAR(45) DEFAULT NULL, CHANGE fee fee DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE donation ADD CONSTRAINT FK_31E581A0DC058279 FOREIGN KEY (payment_type_id) REFERENCES payment_type (id)');
        $this->addSql('CREATE INDEX IDX_31E581A0DC058279 ON donation (payment_type_id)');
        $this->addSql('CREATE INDEX donation_created_at_idx ON donation (created_at)');
        $this->addSql('DROP INDEX fk_donation_contributor1_idx ON donation');
        $this->addSql('CREATE INDEX IDX_31E581A07A19A357 ON donation (contributor_id)');
        $this->addSql('DROP INDEX fk_donation_receipt1_idx ON donation');
        $this->addSql('CREATE INDEX IDX_31E581A02B5CA896 ON donation (receipt_id)');
        $this->addSql('ALTER TABLE donation ADD CONSTRAINT FK_31E581A02B5CA896 FOREIGN KEY (receipt_id) REFERENCES receipt (id)');
        $this->addSql('ALTER TABLE donation ADD CONSTRAINT FK_31E581A07A19A357 FOREIGN KEY (contributor_id) REFERENCES contributor (id)');
        $this->addSql('ALTER TABLE contributor ADD contributor_type_id INT UNSIGNED DEFAULT NULL, CHANGE email email VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE contributor ADD CONSTRAINT FK_DA6F9793834C39 FOREIGN KEY (contributor_type_id) REFERENCES contributor_type (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_DA6F9793E7927C74 ON contributor (email)');
        $this->addSql('CREATE INDEX IDX_DA6F9793834C39 ON contributor (contributor_type_id)');
        $this->addSql('CREATE INDEX contributor_firstname_idx ON contributor (firstname)');
        $this->addSql('CREATE INDEX contributor_lastname_idx ON contributor (lastname)');
        $this->addSql('CREATE INDEX contributor_company_idx ON contributor (company)');
        $this->addSql('DROP INDEX legal_number_UNIQUE ON receipt');
        $this->addSql('ALTER TABLE receipt ADD contributor_id INT UNSIGNED DEFAULT NULL, CHANGE id id INT UNSIGNED AUTO_INCREMENT NOT NULL, CHANGE amount amount DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE receipt ADD CONSTRAINT FK_5399B6457A19A357 FOREIGN KEY (contributor_id) REFERENCES contributor (id)');
        $this->addSql('CREATE INDEX IDX_5399B6457A19A357 ON receipt (contributor_id)');
        $this->addSql('CREATE INDEX receipt_created_at_idx ON receipt (created_at)');
        $this->addSql('ALTER TABLE address DROP FOREIGN KEY FK_D4E6F817A19A357');
        $this->addSql('DROP INDEX fk_address_contributor_idx ON address');
        $this->addSql('CREATE INDEX IDX_D4E6F817A19A357 ON address (contributor_id)');
        $this->addSql('ALTER TABLE address ADD CONSTRAINT FK_D4E6F817A19A357 FOREIGN KEY (contributor_id) REFERENCES contributor (id)');

        $this->addSql("
            INSERT INTO payment_type (slug, name)
            VALUES
            ('cb', 'Carte Bancaire'),
            ('check', 'Chèque'),
            ('cash', 'Espèce'),
            ('bankwire', 'Virement'),
            ('paypal', 'Paypal'),
            ('other', 'Autre'),
            ('flattr', 'Flattr')
        ");

        $this->addSql("
            INSERT INTO contributor_type (slug, name)
            VALUES
            ('personal', 'Particulier'),
            ('company', 'Entreprise'),
            ('assocation', 'Assocation')
        ");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE donation DROP FOREIGN KEY FK_31E581A0DC058279');
        $this->addSql('ALTER TABLE contributor DROP FOREIGN KEY FK_DA6F9793834C39');
        $this->addSql('DROP TABLE payment_type');
        $this->addSql('DROP TABLE configuration');
        $this->addSql('DROP TABLE contributor_type');
        $this->addSql('ALTER TABLE address DROP FOREIGN KEY FK_D4E6F817A19A357');
        $this->addSql('DROP INDEX idx_d4e6f817a19a357 ON address');
        $this->addSql('CREATE INDEX fk_address_contributor_idx ON address (contributor_id)');
        $this->addSql('ALTER TABLE address ADD CONSTRAINT FK_D4E6F817A19A357 FOREIGN KEY (contributor_id) REFERENCES contributor (id)');
        $this->addSql('DROP INDEX UNIQ_DA6F9793E7927C74 ON contributor');
        $this->addSql('DROP INDEX IDX_DA6F9793834C39 ON contributor');
        $this->addSql('DROP INDEX contributor_firstname_idx ON contributor');
        $this->addSql('DROP INDEX contributor_lastname_idx ON contributor');
        $this->addSql('DROP INDEX contributor_company_idx ON contributor');
        $this->addSql('ALTER TABLE contributor DROP contributor_type_id, CHANGE email email VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
        $this->addSql('DROP INDEX IDX_31E581A0DC058279 ON donation');
        $this->addSql('DROP INDEX donation_created_at_idx ON donation');
        $this->addSql('ALTER TABLE donation DROP FOREIGN KEY FK_31E581A07A19A357');
        $this->addSql('ALTER TABLE donation DROP FOREIGN KEY FK_31E581A02B5CA896');
        $this->addSql('ALTER TABLE donation DROP payment_type_id, DROP reference, CHANGE amount amount DOUBLE PRECISION NOT NULL, CHANGE via via VARCHAR(45) NOT NULL COLLATE utf8_unicode_ci, CHANGE fee fee DOUBLE PRECISION NOT NULL');
        $this->addSql('DROP INDEX idx_31e581a07a19a357 ON donation');
        $this->addSql('CREATE INDEX fk_donation_contributor1_idx ON donation (contributor_id)');
        $this->addSql('DROP INDEX idx_31e581a02b5ca896 ON donation');
        $this->addSql('CREATE INDEX fk_donation_receipt1_idx ON donation (receipt_id)');
        $this->addSql('ALTER TABLE donation ADD CONSTRAINT FK_31E581A07A19A357 FOREIGN KEY (contributor_id) REFERENCES contributor (id)');
        $this->addSql('ALTER TABLE donation ADD CONSTRAINT FK_31E581A02B5CA896 FOREIGN KEY (receipt_id) REFERENCES receipt (id)');
        $this->addSql('ALTER TABLE receipt DROP FOREIGN KEY FK_5399B6457A19A357');
        $this->addSql('DROP INDEX IDX_5399B6457A19A357 ON receipt');
        $this->addSql('DROP INDEX receipt_created_at_idx ON receipt');
        $this->addSql('ALTER TABLE receipt DROP contributor_id, CHANGE id id INT UNSIGNED NOT NULL, CHANGE amount amount DOUBLE PRECISION NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX legal_number_UNIQUE ON receipt (legal_number)');
    }
}

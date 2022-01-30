<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220130185731 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE invoice (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, promotion_id INT DEFAULT NULL, serial VARCHAR(255) NOT NULL, amount DOUBLE PRECISION NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_90651744A76ED395 (user_id), INDEX IDX_90651744139DF194 (promotion_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE invoice_product (id INT AUTO_INCREMENT NOT NULL, invoice_id INT NOT NULL, name VARCHAR(255) NOT NULL, quantity INT NOT NULL, price DOUBLE PRECISION NOT NULL, INDEX IDX_2193327E2989F1FD (invoice_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, image_path VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE promotion_code (id INT AUTO_INCREMENT NOT NULL, serial VARCHAR(255) NOT NULL, pourcent TINYINT(1) NOT NULL, fixed TINYINT(1) NOT NULL, amount DOUBLE PRECISION NOT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, role_id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D649D60322AC (role_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_has_product (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, product_id INT DEFAULT NULL, promotion_id INT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_1DA0A5E3A76ED395 (user_id), INDEX IDX_1DA0A5E34584665A (product_id), INDEX IDX_1DA0A5E3139DF194 (promotion_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE invoice ADD CONSTRAINT FK_90651744A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE invoice ADD CONSTRAINT FK_90651744139DF194 FOREIGN KEY (promotion_id) REFERENCES promotion_code (id)');
        $this->addSql('ALTER TABLE invoice_product ADD CONSTRAINT FK_2193327E2989F1FD FOREIGN KEY (invoice_id) REFERENCES invoice (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649D60322AC FOREIGN KEY (role_id) REFERENCES role (id)');
        $this->addSql('ALTER TABLE user_has_product ADD CONSTRAINT FK_1DA0A5E3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_has_product ADD CONSTRAINT FK_1DA0A5E34584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE user_has_product ADD CONSTRAINT FK_1DA0A5E3139DF194 FOREIGN KEY (promotion_id) REFERENCES promotion_code (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE invoice_product DROP FOREIGN KEY FK_2193327E2989F1FD');
        $this->addSql('ALTER TABLE user_has_product DROP FOREIGN KEY FK_1DA0A5E34584665A');
        $this->addSql('ALTER TABLE invoice DROP FOREIGN KEY FK_90651744139DF194');
        $this->addSql('ALTER TABLE user_has_product DROP FOREIGN KEY FK_1DA0A5E3139DF194');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649D60322AC');
        $this->addSql('ALTER TABLE invoice DROP FOREIGN KEY FK_90651744A76ED395');
        $this->addSql('ALTER TABLE user_has_product DROP FOREIGN KEY FK_1DA0A5E3A76ED395');
        $this->addSql('DROP TABLE invoice');
        $this->addSql('DROP TABLE invoice_product');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE promotion_code');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_has_product');
    }
}

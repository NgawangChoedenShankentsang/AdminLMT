<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240123160230 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE licenses (id INT AUTO_INCREMENT NOT NULL, product_id_id INT NOT NULL, created_by_id INT NOT NULL, license_key VARCHAR(255) DEFAULT NULL, start_date DATE NOT NULL, end_date DATE NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', duration VARCHAR(255) DEFAULT NULL, notes VARCHAR(255) DEFAULT NULL, INDEX IDX_7F320F3FDE18E50B (product_id_id), INDEX IDX_7F320F3FB03A8386 (created_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE products (id INT AUTO_INCREMENT NOT NULL, created_by_id INT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', notes VARCHAR(255) DEFAULT NULL, INDEX IDX_B3BA5A5AB03A8386 (created_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE websites (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', notes VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE websites_licenses (websites_id INT NOT NULL, licenses_id INT NOT NULL, INDEX IDX_974B41D5E4DFAB75 (websites_id), INDEX IDX_974B41D56392AAD (licenses_id), PRIMARY KEY(websites_id, licenses_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE licenses ADD CONSTRAINT FK_7F320F3FDE18E50B FOREIGN KEY (product_id_id) REFERENCES products (id)');
        $this->addSql('ALTER TABLE licenses ADD CONSTRAINT FK_7F320F3FB03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE products ADD CONSTRAINT FK_B3BA5A5AB03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE websites_licenses ADD CONSTRAINT FK_974B41D5E4DFAB75 FOREIGN KEY (websites_id) REFERENCES websites (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE websites_licenses ADD CONSTRAINT FK_974B41D56392AAD FOREIGN KEY (licenses_id) REFERENCES licenses (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE licenses DROP FOREIGN KEY FK_7F320F3FDE18E50B');
        $this->addSql('ALTER TABLE licenses DROP FOREIGN KEY FK_7F320F3FB03A8386');
        $this->addSql('ALTER TABLE products DROP FOREIGN KEY FK_B3BA5A5AB03A8386');
        $this->addSql('ALTER TABLE websites_licenses DROP FOREIGN KEY FK_974B41D5E4DFAB75');
        $this->addSql('ALTER TABLE websites_licenses DROP FOREIGN KEY FK_974B41D56392AAD');
        $this->addSql('DROP TABLE licenses');
        $this->addSql('DROP TABLE products');
        $this->addSql('DROP TABLE websites');
        $this->addSql('DROP TABLE websites_licenses');
    }
}

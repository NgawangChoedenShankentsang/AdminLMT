<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240125150421 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE paid (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE licenses ADD paid_by_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE licenses ADD CONSTRAINT FK_7F320F3F7F9BC654 FOREIGN KEY (paid_by_id) REFERENCES paid (id)');
        $this->addSql('CREATE INDEX IDX_7F320F3F7F9BC654 ON licenses (paid_by_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE licenses DROP FOREIGN KEY FK_7F320F3F7F9BC654');
        $this->addSql('DROP TABLE paid');
        $this->addSql('DROP INDEX IDX_7F320F3F7F9BC654 ON licenses');
        $this->addSql('ALTER TABLE licenses DROP paid_by_id');
    }
}

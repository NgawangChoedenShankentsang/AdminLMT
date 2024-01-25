<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240125102911 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE duration (id INT AUTO_INCREMENT NOT NULL, duration VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE licenses ADD duration_id INT DEFAULT NULL, DROP duration');
        $this->addSql('ALTER TABLE licenses ADD CONSTRAINT FK_7F320F3F37B987D8 FOREIGN KEY (duration_id) REFERENCES duration (id)');
        $this->addSql('CREATE INDEX IDX_7F320F3F37B987D8 ON licenses (duration_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE licenses DROP FOREIGN KEY FK_7F320F3F37B987D8');
        $this->addSql('DROP TABLE duration');
        $this->addSql('DROP INDEX IDX_7F320F3F37B987D8 ON licenses');
        $this->addSql('ALTER TABLE licenses ADD duration VARCHAR(255) DEFAULT NULL, DROP duration_id');
    }
}

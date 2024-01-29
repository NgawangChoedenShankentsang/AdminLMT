<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240129122155 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bexio (id INT AUTO_INCREMENT NOT NULL, account_name VARCHAR(255) NOT NULL, account_id INT NOT NULL, url VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE websites ADD bexio_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE websites ADD CONSTRAINT FK_2527D78DA7747A0A FOREIGN KEY (bexio_id) REFERENCES bexio (id)');
        $this->addSql('CREATE INDEX IDX_2527D78DA7747A0A ON websites (bexio_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE websites DROP FOREIGN KEY FK_2527D78DA7747A0A');
        $this->addSql('DROP TABLE bexio');
        $this->addSql('DROP INDEX IDX_2527D78DA7747A0A ON websites');
        $this->addSql('ALTER TABLE websites DROP bexio_id');
    }
}

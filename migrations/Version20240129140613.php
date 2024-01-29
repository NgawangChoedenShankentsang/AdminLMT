<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240129140613 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE licenses_websites (licenses_id INT NOT NULL, websites_id INT NOT NULL, INDEX IDX_E6C7842D6392AAD (licenses_id), INDEX IDX_E6C7842DE4DFAB75 (websites_id), PRIMARY KEY(licenses_id, websites_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE licenses_websites ADD CONSTRAINT FK_E6C7842D6392AAD FOREIGN KEY (licenses_id) REFERENCES licenses (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE licenses_websites ADD CONSTRAINT FK_E6C7842DE4DFAB75 FOREIGN KEY (websites_id) REFERENCES websites (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE websites_licenses DROP FOREIGN KEY FK_974B41D5E4DFAB75');
        $this->addSql('ALTER TABLE websites_licenses DROP FOREIGN KEY FK_974B41D56392AAD');
        $this->addSql('DROP TABLE websites_licenses');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE websites_licenses (websites_id INT NOT NULL, licenses_id INT NOT NULL, INDEX IDX_974B41D5E4DFAB75 (websites_id), INDEX IDX_974B41D56392AAD (licenses_id), PRIMARY KEY(websites_id, licenses_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE websites_licenses ADD CONSTRAINT FK_974B41D5E4DFAB75 FOREIGN KEY (websites_id) REFERENCES websites (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE websites_licenses ADD CONSTRAINT FK_974B41D56392AAD FOREIGN KEY (licenses_id) REFERENCES licenses (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE licenses_websites DROP FOREIGN KEY FK_E6C7842D6392AAD');
        $this->addSql('ALTER TABLE licenses_websites DROP FOREIGN KEY FK_E6C7842DE4DFAB75');
        $this->addSql('DROP TABLE licenses_websites');
    }
}

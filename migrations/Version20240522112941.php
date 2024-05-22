<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240522112941 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE habitat (name VARCHAR(255) NOT NULL, habitats VARCHAR(255) NOT NULL, id INT AUTO_INCREMENT NOT NULL, UNIQUE INDEX UNIQ_3B37B2E85E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE species_habitats (habitat_id INT NOT NULL, species_id INT NOT NULL, INDEX IDX_53255083AFFE2D26 (habitat_id), INDEX IDX_53255083B2A1D860 (species_id), PRIMARY KEY(habitat_id, species_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE species_habitats ADD CONSTRAINT FK_53255083AFFE2D26 FOREIGN KEY (habitat_id) REFERENCES species (id)');
        $this->addSql('ALTER TABLE species_habitats ADD CONSTRAINT FK_53255083B2A1D860 FOREIGN KEY (species_id) REFERENCES habitat (id)');
        $this->addSql('ALTER TABLE species DROP habitats');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE species_habitats DROP FOREIGN KEY FK_53255083AFFE2D26');
        $this->addSql('ALTER TABLE species_habitats DROP FOREIGN KEY FK_53255083B2A1D860');
        $this->addSql('DROP TABLE habitat');
        $this->addSql('DROP TABLE species_habitats');
        $this->addSql('ALTER TABLE species ADD habitats LONGTEXT NOT NULL COMMENT \'(DC2Type:simple_array)\'');
    }
}

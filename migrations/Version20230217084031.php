<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230217084031 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Migrating integer ids to UUIDs';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dinosaur DROP FOREIGN KEY FK_DAEDC56EB2A1D860');
        $this->addSql('ALTER TABLE dinosaur CHANGE id id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', CHANGE species_id species_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE species CHANGE id id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE dinosaur ADD CONSTRAINT FK_DAEDC56EB2A1D860 FOREIGN KEY (species_id) REFERENCES species (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dinosaur DROP FOREIGN KEY FK_DAEDC56EB2A1D860');
        $this->addSql('ALTER TABLE dinosaur CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE species_id species_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE species CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE dinosaur ADD CONSTRAINT FK_DAEDC56EB2A1D860 FOREIGN KEY (species_id) REFERENCES species (id)');
    }
}

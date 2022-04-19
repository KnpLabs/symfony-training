<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211108131941 extends AbstractMigration
{
    public function isTransactional(): bool
    {
        return false;
    }

    public function getDescription(): string
    {
        return 'Introduce the Species entity';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE species (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, habitats LONGTEXT NOT NULL COMMENT \'(DC2Type:simple_array)\', feeding VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_A50FF7125E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE dinosaur ADD species_id INT DEFAULT NULL, DROP species');
        $this->addSql('ALTER TABLE dinosaur ADD CONSTRAINT FK_DAEDC56EB2A1D860 FOREIGN KEY (species_id) REFERENCES species (id)');
        $this->addSql('CREATE INDEX IDX_DAEDC56EB2A1D860 ON dinosaur (species_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dinosaur DROP FOREIGN KEY FK_DAEDC56EB2A1D860');
        $this->addSql('DROP TABLE species');
        $this->addSql('DROP INDEX IDX_DAEDC56EB2A1D860 ON dinosaur');
        $this->addSql('ALTER TABLE dinosaur ADD species VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP species_id');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221021152754 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE enclosure (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, fences VARCHAR(255) NOT NULL, habitats JSON NOT NULL, feeding JSON NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE dinosaur ADD enclosure_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE dinosaur ADD CONSTRAINT FK_DAEDC56ED04FE1E5 FOREIGN KEY (enclosure_id) REFERENCES enclosure (id)');
        $this->addSql('CREATE INDEX IDX_DAEDC56ED04FE1E5 ON dinosaur (enclosure_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dinosaur DROP FOREIGN KEY FK_DAEDC56ED04FE1E5');
        $this->addSql('DROP TABLE enclosure');
        $this->addSql('DROP INDEX IDX_DAEDC56ED04FE1E5 ON dinosaur');
        $this->addSql('ALTER TABLE dinosaur DROP enclosure_id');
    }
}

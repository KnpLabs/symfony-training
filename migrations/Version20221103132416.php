<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221103132416 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE eyesColor (id INT AUTO_INCREMENT NOT NULL, red INT NOT NULL, blue INT NOT NULL, green INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE dinosaur ADD eyes_color_id INT DEFAULT NULL, DROP eyesColor');
        $this->addSql('ALTER TABLE dinosaur ADD CONSTRAINT FK_DAEDC56E2BA5DE30 FOREIGN KEY (eyes_color_id) REFERENCES eyesColor (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_DAEDC56E2BA5DE30 ON dinosaur (eyes_color_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dinosaur DROP FOREIGN KEY FK_DAEDC56E2BA5DE30');
        $this->addSql('DROP TABLE eyesColor');
        $this->addSql('DROP INDEX UNIQ_DAEDC56E2BA5DE30 ON dinosaur');
        $this->addSql('ALTER TABLE dinosaur ADD eyesColor VARCHAR(255) NOT NULL, DROP eyes_color_id');
    }
}

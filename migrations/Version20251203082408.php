<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251203082408 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dinosaur ADD created_by_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE dinosaur ADD CONSTRAINT FK_DAEDC56EB03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_DAEDC56EB03A8386 ON dinosaur (created_by_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dinosaur DROP FOREIGN KEY FK_DAEDC56EB03A8386');
        $this->addSql('DROP INDEX IDX_DAEDC56EB03A8386 ON dinosaur');
        $this->addSql('ALTER TABLE dinosaur DROP created_by_id');
    }
}

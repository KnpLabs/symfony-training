<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230208124132 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE park (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, food_amount INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE dinosaur ADD park_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE dinosaur ADD CONSTRAINT FK_DAEDC56E44990C25 FOREIGN KEY (park_id) REFERENCES park (id)');
        $this->addSql('CREATE INDEX IDX_DAEDC56E44990C25 ON dinosaur (park_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE dinosaur DROP FOREIGN KEY FK_DAEDC56E44990C25');
        $this->addSql('DROP TABLE park');
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('DROP INDEX IDX_DAEDC56E44990C25 ON dinosaur');
        $this->addSql('ALTER TABLE dinosaur DROP park_id');
    }
}

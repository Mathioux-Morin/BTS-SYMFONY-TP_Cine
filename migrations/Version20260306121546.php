<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260306121546 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE movie_lover (id INT AUTO_INCREMENT NOT NULL, uuid VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_UUID (uuid), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE rating (id INT AUTO_INCREMENT NOT NULL, rating INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, id_movie_lover_id INT NOT NULL, id_movie_id INT NOT NULL, INDEX IDX_D8892622AA9712CE (id_movie_lover_id), INDEX IDX_D8892622DF485A69 (id_movie_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE rating ADD CONSTRAINT FK_D8892622AA9712CE FOREIGN KEY (id_movie_lover_id) REFERENCES movie_lover (id)');
        $this->addSql('ALTER TABLE rating ADD CONSTRAINT FK_D8892622DF485A69 FOREIGN KEY (id_movie_id) REFERENCES movie (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rating DROP FOREIGN KEY FK_D8892622AA9712CE');
        $this->addSql('ALTER TABLE rating DROP FOREIGN KEY FK_D8892622DF485A69');
        $this->addSql('DROP TABLE movie_lover');
        $this->addSql('DROP TABLE rating');
    }
}

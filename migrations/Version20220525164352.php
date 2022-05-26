<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220525164352 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE highscore (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, playername VARCHAR(255) NOT NULL, points INTEGER NOT NULL)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__bibliotek AS SELECT id, titel, isbn, författare, bild FROM bibliotek');
        $this->addSql('DROP TABLE bibliotek');
        $this->addSql('CREATE TABLE bibliotek (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, titel VARCHAR(255) NOT NULL, isbn VARCHAR(255) NOT NULL, författare VARCHAR(255) NOT NULL, bild VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO bibliotek (id, titel, isbn, författare, bild) SELECT id, titel, isbn, författare, bild FROM __temp__bibliotek');
        $this->addSql('DROP TABLE __temp__bibliotek');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE highscore');
        $this->addSql('CREATE TEMPORARY TABLE __temp__bibliotek AS SELECT id, titel, isbn, författare, bild FROM bibliotek');
        $this->addSql('DROP TABLE bibliotek');
        $this->addSql('CREATE TABLE bibliotek (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, titel VARCHAR(255) NOT NULL, isbn INTEGER NOT NULL, författare VARCHAR(255) NOT NULL, bild VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO bibliotek (id, titel, isbn, författare, bild) SELECT id, titel, isbn, författare, bild FROM __temp__bibliotek');
        $this->addSql('DROP TABLE __temp__bibliotek');
    }
}

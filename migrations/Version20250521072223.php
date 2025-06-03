<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250521072223 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE candidats (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, session_id INTEGER NOT NULL, nid INTEGER NOT NULL, nom VARCHAR(30) NOT NULL, prénom VARCHAR(30) NOT NULL, date_de_naissance DATETIME NOT NULL, lieu_de_naissance VARCHAR(30) NOT NULL, commentaires VARCHAR(255) NOT NULL, CONSTRAINT FK_3C663B15613FECDF FOREIGN KEY (session_id) REFERENCES sessions (id) NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_3C663B15613FECDF ON candidats (session_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__sessions AS SELECT id, date, motifs, lieu, commentaires FROM sessions
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE sessions
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE sessions (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, date DATE NOT NULL, motifs VARCHAR(255) NOT NULL, lieu VARCHAR(255) NOT NULL, commentaires VARCHAR(255) NOT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO sessions (id, date, motifs, lieu, commentaires) SELECT id, date, motifs, lieu, commentaires FROM __temp__sessions
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__sessions
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            DROP TABLE candidats
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE sessions ADD COLUMN nb_candidats INTEGER NOT NULL
        SQL);
    }
}

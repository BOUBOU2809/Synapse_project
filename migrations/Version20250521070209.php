<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250521070209 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__candidats AS SELECT NID, Nom, Prénom, date_de_naissance, Lieu_de_naissance, commentaires FROM candidats
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE candidats
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE candidats (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nid INTEGER NOT NULL, nom VARCHAR(30) NOT NULL, prénom VARCHAR(30) NOT NULL, date_de_naissance DATETIME NOT NULL, lieu_de_naissance VARCHAR(30) NOT NULL, commentaires VARCHAR(255) NOT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO candidats (nid, nom, prénom, date_de_naissance, lieu_de_naissance, commentaires) SELECT NID, Nom, Prénom, date_de_naissance, Lieu_de_naissance, commentaires FROM __temp__candidats
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__candidats
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__sessions AS SELECT id, date, motifs, lieu, commentaires FROM sessions
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE sessions
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE sessions (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, date DATE NOT NULL, motifs VARCHAR(255) NOT NULL, lieu VARCHAR(255) NOT NULL, commentaires VARCHAR(255) NOT NULL, nb_candidats INTEGER NOT NULL)
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
            CREATE TEMPORARY TABLE __temp__candidats AS SELECT nid, nom, prénom, date_de_naissance, lieu_de_naissance, commentaires FROM candidats
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE candidats
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE candidats (candidats_id INTEGER PRIMARY KEY AUTOINCREMENT DEFAULT NULL, NID INTEGER DEFAULT NULL, Nom CLOB DEFAULT NULL, Prénom INTEGER DEFAULT NULL, date_de_naissance CLOB DEFAULT NULL, Lieu_de_naissance CLOB DEFAULT NULL, commentaires CLOB DEFAULT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO candidats (NID, Nom, Prénom, date_de_naissance, Lieu_de_naissance, commentaires) SELECT nid, nom, prénom, date_de_naissance, lieu_de_naissance, commentaires FROM __temp__candidats
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__candidats
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__sessions AS SELECT id, date, motifs, lieu, commentaires FROM sessions
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE sessions
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE sessions (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, candidats_id INTEGER DEFAULT NULL, date DATE NOT NULL, motifs VARCHAR(255) NOT NULL, lieu VARCHAR(255) NOT NULL, commentaires VARCHAR(255) NOT NULL, CONSTRAINT sessions_candidats_candidats_id_fk FOREIGN KEY (candidats_id) REFERENCES candidats (candidats_id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO sessions (id, date, motifs, lieu, commentaires) SELECT id, date, motifs, lieu, commentaires FROM __temp__sessions
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__sessions
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_9A609D13E4CF8FC2 ON sessions (candidats_id)
        SQL);
    }
}

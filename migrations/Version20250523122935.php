<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250523122935 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE candidat (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, session_id INTEGER NOT NULL, nid INTEGER NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, birth_date DATETIME NOT NULL, birth_place VARCHAR(255) NOT NULL, commentaires VARCHAR(255) NOT NULL, CONSTRAINT FK_6AB5B471613FECDF FOREIGN KEY (session_id) REFERENCES session (id) NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_6AB5B471613FECDF ON candidat (session_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE session (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, statut_id INTEGER NOT NULL, categorie_id INTEGER NOT NULL, date DATETIME NOT NULL, lieu VARCHAR(255) NOT NULL, commentaires VARCHAR(255) NOT NULL, CONSTRAINT FK_D044D5D4F6203804 FOREIGN KEY (statut_id) REFERENCES statut (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D044D5D4BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id) NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_D044D5D4F6203804 ON session (statut_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_D044D5D4BCF5E72D ON session (categorie_id)
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE candidats
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE sessions
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__categorie AS SELECT id, libelle, libelle_court FROM categorie
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE categorie
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE categorie (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, libelle_court VARCHAR(35) NOT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO categorie (id, libelle, libelle_court) SELECT id, libelle, libelle_court FROM __temp__categorie
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__categorie
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__statut AS SELECT id, libelle, libelle_court FROM statut
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE statut
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE statut (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, libelle_court VARCHAR(35) NOT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO statut (id, libelle, libelle_court) SELECT id, libelle, libelle_court FROM __temp__statut
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__statut
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE candidats (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, session_id INTEGER NOT NULL, nid INTEGER NOT NULL, nom VARCHAR(30) NOT NULL COLLATE "BINARY", prénom VARCHAR(30) NOT NULL COLLATE "BINARY", date_de_naissance DATETIME NOT NULL, lieu_de_naissance VARCHAR(30) NOT NULL COLLATE "BINARY", commentaires VARCHAR(255) NOT NULL COLLATE "BINARY", CONSTRAINT FK_3C663B15613FECDF FOREIGN KEY (session_id) REFERENCES sessions (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_3C663B15613FECDF ON candidats (session_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE sessions (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, statut_id INTEGER NOT NULL, categorie_id INTEGER NOT NULL, date DATE NOT NULL, lieu VARCHAR(255) NOT NULL COLLATE "BINARY", commentaires VARCHAR(255) NOT NULL COLLATE "BINARY", CONSTRAINT FK_9A609D13F6203804 FOREIGN KEY (statut_id) REFERENCES statut (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_9A609D13BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_9A609D13BCF5E72D ON sessions (categorie_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_9A609D13F6203804 ON sessions (statut_id)
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE candidat
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE session
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__categorie AS SELECT id, libelle, libelle_court FROM categorie
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE categorie
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE categorie (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, libelle_court VARCHAR(255) NOT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO categorie (id, libelle, libelle_court) SELECT id, libelle, libelle_court FROM __temp__categorie
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__categorie
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__statut AS SELECT id, libelle, libelle_court FROM statut
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE statut
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE statut (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, libelle_court VARCHAR(255) NOT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO statut (id, libelle, libelle_court) SELECT id, libelle, libelle_court FROM __temp__statut
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__statut
        SQL);
    }
}

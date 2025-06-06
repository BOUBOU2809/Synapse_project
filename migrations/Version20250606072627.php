<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250606072627 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__candidat AS SELECT id, session_id, genre_id, statut_candidat_id, test_anglais_id, test_sport_id, test_tami_c_id, test_tami_p_id, nid, nom, prenom, birth_date, birth_place, commentaires FROM candidat
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE candidat
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE candidat (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, session_id INTEGER DEFAULT NULL, genre_id INTEGER DEFAULT NULL, statut_candidat_id INTEGER DEFAULT NULL, test_anglais_id INTEGER DEFAULT NULL, test_sport_id INTEGER DEFAULT NULL, test_tami_c_id INTEGER DEFAULT NULL, test_tami_p_id INTEGER DEFAULT NULL, nid INTEGER NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, birth_date DATETIME NOT NULL, birth_place VARCHAR(255) NOT NULL, commentaires VARCHAR(255) NOT NULL, CONSTRAINT FK_6AB5B471613FECDF FOREIGN KEY (session_id) REFERENCES session (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_6AB5B4714296D31F FOREIGN KEY (genre_id) REFERENCES genre (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_6AB5B4717179982B FOREIGN KEY (statut_candidat_id) REFERENCES statut_candidat (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_6AB5B4711305BE97 FOREIGN KEY (test_anglais_id) REFERENCES test_anglais (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_6AB5B471391BB7AE FOREIGN KEY (test_sport_id) REFERENCES test_sport (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_6AB5B4711AD0DEFA FOREIGN KEY (test_tami_c_id) REFERENCES test_tami_c (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_6AB5B471587C268B FOREIGN KEY (test_tami_p_id) REFERENCES test_tami_p (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO candidat (id, session_id, genre_id, statut_candidat_id, test_anglais_id, test_sport_id, test_tami_c_id, test_tami_p_id, nid, nom, prenom, birth_date, birth_place, commentaires) SELECT id, session_id, genre_id, statut_candidat_id, test_anglais_id, test_sport_id, test_tami_c_id, test_tami_p_id, nid, nom, prenom, birth_date, birth_place, commentaires FROM __temp__candidat
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__candidat
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_6AB5B471587C268B ON candidat (test_tami_p_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_6AB5B4711AD0DEFA ON candidat (test_tami_c_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_6AB5B471391BB7AE ON candidat (test_sport_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_6AB5B4711305BE97 ON candidat (test_anglais_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_6AB5B4717179982B ON candidat (statut_candidat_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_6AB5B4714296D31F ON candidat (genre_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_6AB5B471613FECDF ON candidat (session_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__session AS SELECT id, statut_id, categorie_id, date, lieu, commentaires FROM session
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE session
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE session (id INTEGER NOT NULL, statut_id INTEGER NOT NULL, categorie_id INTEGER NOT NULL, date DATETIME NOT NULL, lieu VARCHAR(255) NOT NULL, commentaires VARCHAR(255) NOT NULL, PRIMARY KEY(id), CONSTRAINT FK_D044D5D4F6203804 FOREIGN KEY (statut_id) REFERENCES statut (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D044D5D4BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO session (id, statut_id, categorie_id, date, lieu, commentaires) SELECT id, statut_id, categorie_id, date, lieu, commentaires FROM __temp__session
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__session
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_D044D5D4BCF5E72D ON session (categorie_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_D044D5D4F6203804 ON session (statut_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__candidat AS SELECT id, session_id, genre_id, statut_candidat_id, test_anglais_id, test_sport_id, test_tami_c_id, test_tami_p_id, nid, nom, prenom, birth_date, birth_place, commentaires FROM candidat
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE candidat
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE candidat (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, session_id INTEGER NOT NULL, genre_id INTEGER NOT NULL, statut_candidat_id INTEGER NOT NULL, test_anglais_id INTEGER NOT NULL, test_sport_id INTEGER NOT NULL, test_tami_c_id INTEGER NOT NULL, test_tami_p_id INTEGER NOT NULL, nid INTEGER NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, birth_date DATETIME NOT NULL, birth_place VARCHAR(255) NOT NULL, commentaires VARCHAR(255) NOT NULL, CONSTRAINT FK_6AB5B471613FECDF FOREIGN KEY (session_id) REFERENCES session (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_6AB5B4714296D31F FOREIGN KEY (genre_id) REFERENCES genre (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_6AB5B4717179982B FOREIGN KEY (statut_candidat_id) REFERENCES statut_candidat (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_6AB5B4711305BE97 FOREIGN KEY (test_anglais_id) REFERENCES test_anglais (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_6AB5B471391BB7AE FOREIGN KEY (test_sport_id) REFERENCES test_sport (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_6AB5B4711AD0DEFA FOREIGN KEY (test_tami_c_id) REFERENCES test_tami_c (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_6AB5B471587C268B FOREIGN KEY (test_tami_p_id) REFERENCES test_tami_p (id) NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO candidat (id, session_id, genre_id, statut_candidat_id, test_anglais_id, test_sport_id, test_tami_c_id, test_tami_p_id, nid, nom, prenom, birth_date, birth_place, commentaires) SELECT id, session_id, genre_id, statut_candidat_id, test_anglais_id, test_sport_id, test_tami_c_id, test_tami_p_id, nid, nom, prenom, birth_date, birth_place, commentaires FROM __temp__candidat
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__candidat
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_6AB5B471613FECDF ON candidat (session_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_6AB5B4714296D31F ON candidat (genre_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_6AB5B4717179982B ON candidat (statut_candidat_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_6AB5B4711305BE97 ON candidat (test_anglais_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_6AB5B471391BB7AE ON candidat (test_sport_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_6AB5B4711AD0DEFA ON candidat (test_tami_c_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_6AB5B471587C268B ON candidat (test_tami_p_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__session AS SELECT id, statut_id, categorie_id, date, lieu, commentaires FROM session
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE session
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE session (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, statut_id INTEGER NOT NULL, categorie_id INTEGER NOT NULL, date DATETIME NOT NULL, lieu VARCHAR(255) NOT NULL, commentaires VARCHAR(255) NOT NULL, CONSTRAINT FK_D044D5D4F6203804 FOREIGN KEY (statut_id) REFERENCES statut (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D044D5D4BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id) NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO session (id, statut_id, categorie_id, date, lieu, commentaires) SELECT id, statut_id, categorie_id, date, lieu, commentaires FROM __temp__session
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__session
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_D044D5D4F6203804 ON session (statut_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_D044D5D4BCF5E72D ON session (categorie_id)
        SQL);
    }
}

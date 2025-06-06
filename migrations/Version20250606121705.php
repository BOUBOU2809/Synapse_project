<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250606121705 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE resultats_sous_test_tami_c (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, sous_tests_id INTEGER DEFAULT NULL, nom_item VARCHAR(255) DEFAULT NULL, valeur_response VARCHAR(255) DEFAULT NULL, codage DOUBLE PRECISION DEFAULT NULL, CONSTRAINT FK_5CD0C654FD963D24 FOREIGN KEY (sous_tests_id) REFERENCES sous_test_tami_c (id) NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_5CD0C654FD963D24 ON resultats_sous_test_tami_c (sous_tests_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE sous_test_tami_c (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, test_tami_c_id INTEGER DEFAULT NULL, nom_sous_test VARCHAR(255) DEFAULT NULL, CONSTRAINT FK_35116A9C1AD0DEFA FOREIGN KEY (test_tami_c_id) REFERENCES test_tami_c (id) NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_35116A9C1AD0DEFA ON sous_test_tami_c (test_tami_c_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE test_tami_c (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, candidats_id INTEGER DEFAULT NULL, nom_test VARCHAR(255) DEFAULT NULL, date_passage DATETIME DEFAULT NULL, CONSTRAINT FK_752819AFE4CF8FC2 FOREIGN KEY (candidats_id) REFERENCES candidat (id) NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_752819AFE4CF8FC2 ON test_tami_c (candidats_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__epreuve AS SELECT id, epreuves_id, code_epreuve_sportive, note_brute, cotation FROM epreuve
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE epreuve
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE epreuve (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, test_sport_id INTEGER DEFAULT NULL, code_epreuve_sportive INTEGER DEFAULT NULL, note_brute DOUBLE PRECISION DEFAULT NULL, cotation INTEGER DEFAULT NULL, CONSTRAINT FK_D6ADE47F391BB7AE FOREIGN KEY (test_sport_id) REFERENCES test_sport (id) NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO epreuve (id, test_sport_id, code_epreuve_sportive, note_brute, cotation) SELECT id, epreuves_id, code_epreuve_sportive, note_brute, cotation FROM __temp__epreuve
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__epreuve
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_D6ADE47F391BB7AE ON epreuve (test_sport_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            DROP TABLE resultats_sous_test_tami_c
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE sous_test_tami_c
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE test_tami_c
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__epreuve AS SELECT id, test_sport_id, code_epreuve_sportive, note_brute, cotation FROM epreuve
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE epreuve
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE epreuve (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, epreuves_id INTEGER DEFAULT NULL, code_epreuve_sportive INTEGER DEFAULT NULL, note_brute DOUBLE PRECISION DEFAULT NULL, cotation INTEGER DEFAULT NULL, CONSTRAINT FK_D6ADE47F2860B1BF FOREIGN KEY (epreuves_id) REFERENCES test_sport (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO epreuve (id, epreuves_id, code_epreuve_sportive, note_brute, cotation) SELECT id, test_sport_id, code_epreuve_sportive, note_brute, cotation FROM __temp__epreuve
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__epreuve
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_D6ADE47F2860B1BF ON epreuve (epreuves_id)
        SQL);
    }
}

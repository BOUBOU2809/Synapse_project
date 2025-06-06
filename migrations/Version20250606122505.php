<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250606122505 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE resultats_sous_test_tami_p (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, sous_tests_id INTEGER DEFAULT NULL, nom_item VARCHAR(255) DEFAULT NULL, valeur_response VARCHAR(255) DEFAULT NULL, codage DOUBLE PRECISION DEFAULT NULL, CONSTRAINT FK_D86E878AFD963D24 FOREIGN KEY (sous_tests_id) REFERENCES sous_test_tami_p (id) NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_D86E878AFD963D24 ON resultats_sous_test_tami_p (sous_tests_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE sous_test_tami_p (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, test_tami_p_id INTEGER DEFAULT NULL, nom_sous_test VARCHAR(255) DEFAULT NULL, CONSTRAINT FK_B1AF2B42587C268B FOREIGN KEY (test_tami_p_id) REFERENCES test_tami_p (id) NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_B1AF2B42587C268B ON sous_test_tami_p (test_tami_p_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE test_tami_p (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, candidats_id INTEGER DEFAULT NULL, nom_test VARCHAR(255) DEFAULT NULL, date_passage DATETIME DEFAULT NULL, CONSTRAINT FK_F1965871E4CF8FC2 FOREIGN KEY (candidats_id) REFERENCES candidat (id) NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_F1965871E4CF8FC2 ON test_tami_p (candidats_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            DROP TABLE resultats_sous_test_tami_p
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE sous_test_tami_p
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE test_tami_p
        SQL);
    }
}

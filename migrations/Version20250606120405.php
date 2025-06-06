<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250606120405 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__test_anglais AS SELECT id, candidats_id, date_passage, note_brute FROM test_anglais
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE test_anglais
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE test_anglais (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, candidats_id INTEGER DEFAULT NULL, date_passage DATETIME DEFAULT NULL, note_brute INTEGER DEFAULT NULL, CONSTRAINT FK_30D69054E4CF8FC2 FOREIGN KEY (candidats_id) REFERENCES candidat (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO test_anglais (id, candidats_id, date_passage, note_brute) SELECT id, candidats_id, date_passage, note_brute FROM __temp__test_anglais
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__test_anglais
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_30D69054E4CF8FC2 ON test_anglais (candidats_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__test_anglais AS SELECT id, candidats_id, date_passage, note_brute FROM test_anglais
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE test_anglais
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE test_anglais (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, candidats_id INTEGER DEFAULT NULL, test_anglais_id INTEGER DEFAULT NULL, date_passage DATETIME DEFAULT NULL, note_brute INTEGER DEFAULT NULL, CONSTRAINT FK_30D69054E4CF8FC2 FOREIGN KEY (candidats_id) REFERENCES candidat (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_30D690541305BE97 FOREIGN KEY (test_anglais_id) REFERENCES candidat (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO test_anglais (id, candidats_id, date_passage, note_brute) SELECT id, candidats_id, date_passage, note_brute FROM __temp__test_anglais
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__test_anglais
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_30D69054E4CF8FC2 ON test_anglais (candidats_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_30D690541305BE97 ON test_anglais (test_anglais_id)
        SQL);
    }
}

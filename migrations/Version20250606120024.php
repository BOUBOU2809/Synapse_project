<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250606120024 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__test_sport AS SELECT id, test_sport_id, date_passage FROM test_sport
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE test_sport
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE test_sport (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, candidats_id INTEGER DEFAULT NULL, date_passage DATETIME DEFAULT NULL, CONSTRAINT FK_115B49D9E4CF8FC2 FOREIGN KEY (candidats_id) REFERENCES candidat (id) NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO test_sport (id, candidats_id, date_passage) SELECT id, test_sport_id, date_passage FROM __temp__test_sport
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__test_sport
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_115B49D9E4CF8FC2 ON test_sport (candidats_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__test_sport AS SELECT id, candidats_id, date_passage FROM test_sport
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE test_sport
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE test_sport (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, test_sport_id INTEGER DEFAULT NULL, date_passage DATETIME DEFAULT NULL, CONSTRAINT FK_115B49D9391BB7AE FOREIGN KEY (test_sport_id) REFERENCES candidat (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO test_sport (id, test_sport_id, date_passage) SELECT id, candidats_id, date_passage FROM __temp__test_sport
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__test_sport
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_115B49D9391BB7AE ON test_sport (test_sport_id)
        SQL);
    }
}

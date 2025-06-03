<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250520140339 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE sessions ADD COLUMN lieu VARCHAR(255) NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE sessions ADD COLUMN commentaires VARCHAR(255) NOT NULL
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__sessions AS SELECT id, date, nb_candidats, motifs FROM sessions
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE sessions
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE sessions (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, date DATE NOT NULL, nb_candidats INTEGER NOT NULL, motifs VARCHAR(255) NOT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO sessions (id, date, nb_candidats, motifs) SELECT id, date, nb_candidats, motifs FROM __temp__sessions
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__sessions
        SQL);
    }
}

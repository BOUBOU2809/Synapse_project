<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250611080232 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE iteration (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, decision_date DATETIME NOT NULL, start_date DATETIME NOT NULL, end_date DATETIME NOT NULL, label VARCHAR(255) NOT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE iteration_session (iteration_id INTEGER NOT NULL, session_id INTEGER NOT NULL, PRIMARY KEY(iteration_id, session_id), CONSTRAINT FK_80AE961B48E3E1 FOREIGN KEY (iteration_id) REFERENCES iteration (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_80AE96613FECDF FOREIGN KEY (session_id) REFERENCES session (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_80AE961B48E3E1 ON iteration_session (iteration_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_80AE96613FECDF ON iteration_session (session_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            DROP TABLE iteration
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE iteration_session
        SQL);
    }
}

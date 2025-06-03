<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250526070326 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE sous_test_c (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, test_tami_c_id INTEGER NOT NULL, nom_sous_test VARCHAR(255) NOT NULL, CONSTRAINT FK_63565A391AD0DEFA FOREIGN KEY (test_tami_c_id) REFERENCES test_tami_c (id) NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_63565A391AD0DEFA ON sous_test_c (test_tami_c_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE sous_test_p (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, test_tami_p_id INTEGER NOT NULL, nom_sous_test VARCHAR(255) NOT NULL, CONSTRAINT FK_E7E81BE7587C268B FOREIGN KEY (test_tami_p_id) REFERENCES test_tami_p (id) NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_E7E81BE7587C268B ON sous_test_p (test_tami_p_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            DROP TABLE sous_test_c
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE sous_test_p
        SQL);
    }
}

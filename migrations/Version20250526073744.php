<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250526073744 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE epreuves (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, test_sport_id INTEGER NOT NULL, code_epreuves_sportives INTEGER NOT NULL, note_brute INTEGER NOT NULL, cotation INTEGER NOT NULL, CONSTRAINT FK_DB620E42391BB7AE FOREIGN KEY (test_sport_id) REFERENCES test_sport (id) NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_DB620E42391BB7AE ON epreuves (test_sport_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE resultats_bruts_c (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, sous_test_c_id INTEGER NOT NULL, nom_item VARCHAR(255) NOT NULL, valeur_response VARCHAR(255) NOT NULL, codage INTEGER NOT NULL, CONSTRAINT FK_EBC437298FA75A53 FOREIGN KEY (sous_test_c_id) REFERENCES sous_test_c (id) NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_EBC437298FA75A53 ON resultats_bruts_c (sous_test_c_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE resultats_bruts_p (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, sous_test_p_id INTEGER NOT NULL, nom_item VARCHAR(255) NOT NULL, valeur_response VARCHAR(255) NOT NULL, codage INTEGER NOT NULL, CONSTRAINT FK_6F7A76F7CD0BA222 FOREIGN KEY (sous_test_p_id) REFERENCES sous_test_p (id) NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_6F7A76F7CD0BA222 ON resultats_bruts_p (sous_test_p_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            DROP TABLE epreuves
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE resultats_bruts_c
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE resultats_bruts_p
        SQL);
    }
}

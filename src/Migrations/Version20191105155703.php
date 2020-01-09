<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191105155703 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tournoi_user DROP FOREIGN KEY FK_D0703ACD98DE13AC');
        $this->addSql('DROP INDEX IDX_D0703ACD98DE13AC ON tournoi_user');
        $this->addSql('ALTER TABLE tournoi_user ADD partenaire_mixte_id INT DEFAULT NULL, ADD resultat_double VARCHAR(30) DEFAULT NULL, ADD resultat_mixte VARCHAR(30) DEFAULT NULL, ADD nb_tableaux INT DEFAULT NULL, ADD inscription_simple TINYINT(1) DEFAULT NULL, ADD inscription_double TINYINT(1) DEFAULT NULL, ADD inscription_mixte TINYINT(1) DEFAULT NULL, ADD participation_simple TINYINT(1) DEFAULT NULL, ADD participation_double TINYINT(1) DEFAULT NULL, ADD participation_mixte TINYINT(1) DEFAULT NULL, CHANGE partenaire_id partenaire_double_id INT DEFAULT NULL, CHANGE resultat resultat_simple VARCHAR(30) DEFAULT NULL');
        $this->addSql('ALTER TABLE tournoi_user ADD CONSTRAINT FK_D0703ACD486735A1 FOREIGN KEY (partenaire_double_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE tournoi_user ADD CONSTRAINT FK_D0703ACD5691070C FOREIGN KEY (partenaire_mixte_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_D0703ACD486735A1 ON tournoi_user (partenaire_double_id)');
        $this->addSql('CREATE INDEX IDX_D0703ACD5691070C ON tournoi_user (partenaire_mixte_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tournoi_user DROP FOREIGN KEY FK_D0703ACD486735A1');
        $this->addSql('ALTER TABLE tournoi_user DROP FOREIGN KEY FK_D0703ACD5691070C');
        $this->addSql('DROP INDEX IDX_D0703ACD486735A1 ON tournoi_user');
        $this->addSql('DROP INDEX IDX_D0703ACD5691070C ON tournoi_user');
        $this->addSql('ALTER TABLE tournoi_user ADD partenaire_id INT DEFAULT NULL, ADD resultat VARCHAR(30) DEFAULT NULL COLLATE utf8mb4_unicode_ci, DROP partenaire_double_id, DROP partenaire_mixte_id, DROP resultat_simple, DROP resultat_double, DROP resultat_mixte, DROP nb_tableaux, DROP inscription_simple, DROP inscription_double, DROP inscription_mixte, DROP participation_simple, DROP participation_double, DROP participation_mixte');
        $this->addSql('ALTER TABLE tournoi_user ADD CONSTRAINT FK_D0703ACD98DE13AC FOREIGN KEY (partenaire_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_D0703ACD98DE13AC ON tournoi_user (partenaire_id)');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191014221552 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tournoi_user ADD partenaire_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tournoi_user ADD CONSTRAINT FK_D0703ACD98DE13AC FOREIGN KEY (partenaire_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_D0703ACD98DE13AC ON tournoi_user (partenaire_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tournoi_user DROP FOREIGN KEY FK_D0703ACD98DE13AC');
        $this->addSql('DROP INDEX IDX_D0703ACD98DE13AC ON tournoi_user');
        $this->addSql('ALTER TABLE tournoi_user DROP partenaire_id');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191116213113 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE interclub_veteran ADD team_home_id INT DEFAULT NULL, ADD team_ext_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE interclub_veteran ADD CONSTRAINT FK_21CAE2D4D7B4B9AB FOREIGN KEY (team_home_id) REFERENCES team_veteran (id)');
        $this->addSql('ALTER TABLE interclub_veteran ADD CONSTRAINT FK_21CAE2D42B1FF874 FOREIGN KEY (team_ext_id) REFERENCES team_veteran (id)');
        $this->addSql('CREATE INDEX IDX_21CAE2D4D7B4B9AB ON interclub_veteran (team_home_id)');
        $this->addSql('CREATE INDEX IDX_21CAE2D42B1FF874 ON interclub_veteran (team_ext_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE interclub_veteran DROP FOREIGN KEY FK_21CAE2D4D7B4B9AB');
        $this->addSql('ALTER TABLE interclub_veteran DROP FOREIGN KEY FK_21CAE2D42B1FF874');
        $this->addSql('DROP INDEX IDX_21CAE2D4D7B4B9AB ON interclub_veteran');
        $this->addSql('DROP INDEX IDX_21CAE2D42B1FF874 ON interclub_veteran');
        $this->addSql('ALTER TABLE interclub_veteran DROP team_home_id, DROP team_ext_id');
    }
}

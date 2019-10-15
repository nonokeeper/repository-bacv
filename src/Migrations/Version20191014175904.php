<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191014175904 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE interclub_veteran ADD score VARCHAR(3) DEFAULT NULL');
        $this->addSql('ALTER TABLE interclub ADD team_home_id INT DEFAULT NULL, ADD team_ext_id INT DEFAULT NULL, ADD saison_id INT DEFAULT NULL, ADD score VARCHAR(3) DEFAULT NULL, DROP slug, DROP type');
        $this->addSql('ALTER TABLE interclub ADD CONSTRAINT FK_890EAFC8D7B4B9AB FOREIGN KEY (team_home_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE interclub ADD CONSTRAINT FK_890EAFC82B1FF874 FOREIGN KEY (team_ext_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE interclub ADD CONSTRAINT FK_890EAFC8F965414C FOREIGN KEY (saison_id) REFERENCES saison (id)');
        $this->addSql('CREATE INDEX IDX_890EAFC8D7B4B9AB ON interclub (team_home_id)');
        $this->addSql('CREATE INDEX IDX_890EAFC82B1FF874 ON interclub (team_ext_id)');
        $this->addSql('CREATE INDEX IDX_890EAFC8F965414C ON interclub (saison_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE interclub DROP FOREIGN KEY FK_890EAFC8D7B4B9AB');
        $this->addSql('ALTER TABLE interclub DROP FOREIGN KEY FK_890EAFC82B1FF874');
        $this->addSql('ALTER TABLE interclub DROP FOREIGN KEY FK_890EAFC8F965414C');
        $this->addSql('DROP INDEX IDX_890EAFC8D7B4B9AB ON interclub');
        $this->addSql('DROP INDEX IDX_890EAFC82B1FF874 ON interclub');
        $this->addSql('DROP INDEX IDX_890EAFC8F965414C ON interclub');
        $this->addSql('ALTER TABLE interclub ADD slug VARCHAR(10) NOT NULL COLLATE utf8mb4_unicode_ci, ADD type VARCHAR(30) NOT NULL COLLATE utf8mb4_unicode_ci, DROP team_home_id, DROP team_ext_id, DROP saison_id, DROP score');
        $this->addSql('ALTER TABLE interclub_veteran DROP score');
    }
}

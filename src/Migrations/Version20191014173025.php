<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191014173025 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX IDX_8D93D6496125B98A ON user');
        $this->addSql('ALTER TABLE user DROP team_veteran_id');
        $this->addSql('ALTER TABLE interclub DROP FOREIGN KEY FK_890EAFC825856D1E');
        $this->addSql('ALTER TABLE interclub DROP FOREIGN KEY FK_890EAFC82B1FF874');
        $this->addSql('ALTER TABLE interclub DROP FOREIGN KEY FK_890EAFC878CB0327');
        $this->addSql('ALTER TABLE interclub DROP FOREIGN KEY FK_890EAFC8D7B4B9AB');
        $this->addSql('ALTER TABLE interclub DROP FOREIGN KEY FK_890EAFC8F965414C');
        $this->addSql('DROP INDEX IDX_890EAFC82B1FF874 ON interclub');
        $this->addSql('DROP INDEX IDX_890EAFC825856D1E ON interclub');
        $this->addSql('DROP INDEX IDX_890EAFC8D7B4B9AB ON interclub');
        $this->addSql('DROP INDEX IDX_890EAFC878CB0327 ON interclub');
        $this->addSql('DROP INDEX IDX_890EAFC8F965414C ON interclub');
        $this->addSql('ALTER TABLE interclub DROP saison_id, DROP club_home_id, DROP team_home_id, DROP team_ext_id, DROP club_ext_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE interclub ADD saison_id INT NOT NULL, ADD club_home_id INT DEFAULT NULL, ADD team_home_id INT NOT NULL, ADD team_ext_id INT NOT NULL, ADD club_ext_id INT NOT NULL');
        $this->addSql('ALTER TABLE interclub ADD CONSTRAINT FK_890EAFC825856D1E FOREIGN KEY (club_home_id) REFERENCES club (id)');
        $this->addSql('ALTER TABLE interclub ADD CONSTRAINT FK_890EAFC82B1FF874 FOREIGN KEY (team_ext_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE interclub ADD CONSTRAINT FK_890EAFC878CB0327 FOREIGN KEY (club_ext_id) REFERENCES club (id)');
        $this->addSql('ALTER TABLE interclub ADD CONSTRAINT FK_890EAFC8D7B4B9AB FOREIGN KEY (team_home_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE interclub ADD CONSTRAINT FK_890EAFC8F965414C FOREIGN KEY (saison_id) REFERENCES saison (id)');
        $this->addSql('CREATE INDEX IDX_890EAFC82B1FF874 ON interclub (team_ext_id)');
        $this->addSql('CREATE INDEX IDX_890EAFC825856D1E ON interclub (club_home_id)');
        $this->addSql('CREATE INDEX IDX_890EAFC8D7B4B9AB ON interclub (team_home_id)');
        $this->addSql('CREATE INDEX IDX_890EAFC878CB0327 ON interclub (club_ext_id)');
        $this->addSql('CREATE INDEX IDX_890EAFC8F965414C ON interclub (saison_id)');
        $this->addSql('ALTER TABLE user ADD team_veteran_id INT DEFAULT NULL');
        $this->addSql('CREATE INDEX IDX_8D93D6496125B98A ON user (team_veteran_id)');
    }
}

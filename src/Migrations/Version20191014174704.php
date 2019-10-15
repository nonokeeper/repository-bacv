<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191014174704 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE interclub_veteran_team_veteran (interclub_veteran_id INT NOT NULL, team_veteran_id INT NOT NULL, INDEX IDX_4092A53CFB38E23D (interclub_veteran_id), INDEX IDX_4092A53C6125B98A (team_veteran_id), PRIMARY KEY(interclub_veteran_id, team_veteran_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE interclub_veteran_team_veteran ADD CONSTRAINT FK_4092A53CFB38E23D FOREIGN KEY (interclub_veteran_id) REFERENCES interclub_veteran (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE interclub_veteran_team_veteran ADD CONSTRAINT FK_4092A53C6125B98A FOREIGN KEY (team_veteran_id) REFERENCES team_veteran (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE interclub_veteran ADD saison_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE interclub_veteran ADD CONSTRAINT FK_21CAE2D4F965414C FOREIGN KEY (saison_id) REFERENCES saison (id)');
        $this->addSql('CREATE INDEX IDX_21CAE2D4F965414C ON interclub_veteran (saison_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE interclub_veteran_team_veteran');
        $this->addSql('ALTER TABLE interclub_veteran DROP FOREIGN KEY FK_21CAE2D4F965414C');
        $this->addSql('DROP INDEX IDX_21CAE2D4F965414C ON interclub_veteran');
        $this->addSql('ALTER TABLE interclub_veteran DROP saison_id');
    }
}

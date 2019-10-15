<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191014175116 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE interclub_team');
        $this->addSql('DROP TABLE interclub_veteran_team_veteran');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE interclub_team (interclub_id INT NOT NULL, team_id INT NOT NULL, INDEX IDX_B577724537DA8F60 (interclub_id), INDEX IDX_B5777245296CD8AE (team_id), PRIMARY KEY(interclub_id, team_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE interclub_veteran_team_veteran (interclub_veteran_id INT NOT NULL, team_veteran_id INT NOT NULL, INDEX IDX_4092A53CFB38E23D (interclub_veteran_id), INDEX IDX_4092A53C6125B98A (team_veteran_id), PRIMARY KEY(interclub_veteran_id, team_veteran_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE interclub_team ADD CONSTRAINT FK_B5777245296CD8AE FOREIGN KEY (team_id) REFERENCES team (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE interclub_team ADD CONSTRAINT FK_B577724537DA8F60 FOREIGN KEY (interclub_id) REFERENCES interclub (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE interclub_veteran_team_veteran ADD CONSTRAINT FK_4092A53C6125B98A FOREIGN KEY (team_veteran_id) REFERENCES team_veteran (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE interclub_veteran_team_veteran ADD CONSTRAINT FK_4092A53CFB38E23D FOREIGN KEY (interclub_veteran_id) REFERENCES interclub_veteran (id) ON DELETE CASCADE');
    }
}

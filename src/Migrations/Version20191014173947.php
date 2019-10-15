<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191014173947 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE team_saison (team_id INT NOT NULL, saison_id INT NOT NULL, INDEX IDX_B6CB925F296CD8AE (team_id), INDEX IDX_B6CB925FF965414C (saison_id), PRIMARY KEY(team_id, saison_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE interclub_veteran (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, date_rencontre DATE DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE interclub_veteran_saison (interclub_veteran_id INT NOT NULL, saison_id INT NOT NULL, INDEX IDX_86C897FBFB38E23D (interclub_veteran_id), INDEX IDX_86C897FBF965414C (saison_id), PRIMARY KEY(interclub_veteran_id, saison_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE interclub_veteran_user (interclub_veteran_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_C012F00DFB38E23D (interclub_veteran_id), INDEX IDX_C012F00DA76ED395 (user_id), PRIMARY KEY(interclub_veteran_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE interclub_team (interclub_id INT NOT NULL, team_id INT NOT NULL, INDEX IDX_B577724537DA8F60 (interclub_id), INDEX IDX_B5777245296CD8AE (team_id), PRIMARY KEY(interclub_id, team_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE interclub_user (interclub_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_FC04021337DA8F60 (interclub_id), INDEX IDX_FC040213A76ED395 (user_id), PRIMARY KEY(interclub_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE team_saison ADD CONSTRAINT FK_B6CB925F296CD8AE FOREIGN KEY (team_id) REFERENCES team (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE team_saison ADD CONSTRAINT FK_B6CB925FF965414C FOREIGN KEY (saison_id) REFERENCES saison (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE interclub_veteran_saison ADD CONSTRAINT FK_86C897FBFB38E23D FOREIGN KEY (interclub_veteran_id) REFERENCES interclub_veteran (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE interclub_veteran_saison ADD CONSTRAINT FK_86C897FBF965414C FOREIGN KEY (saison_id) REFERENCES saison (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE interclub_veteran_user ADD CONSTRAINT FK_C012F00DFB38E23D FOREIGN KEY (interclub_veteran_id) REFERENCES interclub_veteran (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE interclub_veteran_user ADD CONSTRAINT FK_C012F00DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE interclub_team ADD CONSTRAINT FK_B577724537DA8F60 FOREIGN KEY (interclub_id) REFERENCES interclub (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE interclub_team ADD CONSTRAINT FK_B5777245296CD8AE FOREIGN KEY (team_id) REFERENCES team (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE interclub_user ADD CONSTRAINT FK_FC04021337DA8F60 FOREIGN KEY (interclub_id) REFERENCES interclub (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE interclub_user ADD CONSTRAINT FK_FC040213A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE interclub_veteran_saison DROP FOREIGN KEY FK_86C897FBFB38E23D');
        $this->addSql('ALTER TABLE interclub_veteran_user DROP FOREIGN KEY FK_C012F00DFB38E23D');
        $this->addSql('DROP TABLE team_saison');
        $this->addSql('DROP TABLE interclub_veteran');
        $this->addSql('DROP TABLE interclub_veteran_saison');
        $this->addSql('DROP TABLE interclub_veteran_user');
        $this->addSql('DROP TABLE interclub_team');
        $this->addSql('DROP TABLE interclub_user');
    }
}

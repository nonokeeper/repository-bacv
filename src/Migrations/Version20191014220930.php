<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191014220930 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE tournoi_user (id INT AUTO_INCREMENT NOT NULL, tournoi_id INT NOT NULL, user_id INT NOT NULL, inscription TINYINT(1) DEFAULT NULL, participation TINYINT(1) DEFAULT NULL, resultat VARCHAR(30) DEFAULT NULL, INDEX IDX_D0703ACDF607770A (tournoi_id), INDEX IDX_D0703ACDA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tournoi_user ADD CONSTRAINT FK_D0703ACDF607770A FOREIGN KEY (tournoi_id) REFERENCES tournoi (id)');
        $this->addSql('ALTER TABLE tournoi_user ADD CONSTRAINT FK_D0703ACDA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE tournoi ADD club_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tournoi ADD CONSTRAINT FK_18AFD9DF61190A32 FOREIGN KEY (club_id) REFERENCES club (id)');
        $this->addSql('CREATE INDEX IDX_18AFD9DF61190A32 ON tournoi (club_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE tournoi_user');
        $this->addSql('ALTER TABLE tournoi DROP FOREIGN KEY FK_18AFD9DF61190A32');
        $this->addSql('DROP INDEX IDX_18AFD9DF61190A32 ON tournoi');
        $this->addSql('ALTER TABLE tournoi DROP club_id');
    }
}

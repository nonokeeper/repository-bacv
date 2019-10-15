<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191014214435 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE interclub_user');
        $this->addSql('DROP TABLE interclub_veteran_user');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE interclub_user (interclub_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_FC04021337DA8F60 (interclub_id), INDEX IDX_FC040213A76ED395 (user_id), PRIMARY KEY(interclub_id, user_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE interclub_veteran_user (interclub_veteran_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_C012F00DFB38E23D (interclub_veteran_id), INDEX IDX_C012F00DA76ED395 (user_id), PRIMARY KEY(interclub_veteran_id, user_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE interclub_user ADD CONSTRAINT FK_FC04021337DA8F60 FOREIGN KEY (interclub_id) REFERENCES interclub (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE interclub_user ADD CONSTRAINT FK_FC040213A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE interclub_veteran_user ADD CONSTRAINT FK_C012F00DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE interclub_veteran_user ADD CONSTRAINT FK_C012F00DFB38E23D FOREIGN KEY (interclub_veteran_id) REFERENCES interclub_veteran (id) ON DELETE CASCADE');
    }
}

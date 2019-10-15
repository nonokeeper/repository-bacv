<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191014174430 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE interclub_veteran_saison');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE interclub_veteran_saison (interclub_veteran_id INT NOT NULL, saison_id INT NOT NULL, INDEX IDX_86C897FBFB38E23D (interclub_veteran_id), INDEX IDX_86C897FBF965414C (saison_id), PRIMARY KEY(interclub_veteran_id, saison_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE interclub_veteran_saison ADD CONSTRAINT FK_86C897FBF965414C FOREIGN KEY (saison_id) REFERENCES saison (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE interclub_veteran_saison ADD CONSTRAINT FK_86C897FBFB38E23D FOREIGN KEY (interclub_veteran_id) REFERENCES interclub_veteran (id) ON DELETE CASCADE');
    }
}

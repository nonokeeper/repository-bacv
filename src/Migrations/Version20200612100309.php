<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200612100309 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE lien_doodle (id INT AUTO_INCREMENT NOT NULL, doodle_id INT NOT NULL, personne_id INT NOT NULL, item_id INT DEFAULT NULL, value VARCHAR(255) DEFAULT NULL, updated_dt DATETIME DEFAULT NULL, INDEX IDX_4ABFED90C9EC860E (doodle_id), INDEX IDX_4ABFED90A21BD112 (personne_id), INDEX IDX_4ABFED90126F525E (item_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE lien_doodle ADD CONSTRAINT FK_4ABFED90C9EC860E FOREIGN KEY (doodle_id) REFERENCES doodle (id)');
        $this->addSql('ALTER TABLE lien_doodle ADD CONSTRAINT FK_4ABFED90A21BD112 FOREIGN KEY (personne_id) REFERENCES personne (id)');
        $this->addSql('ALTER TABLE lien_doodle ADD CONSTRAINT FK_4ABFED90126F525E FOREIGN KEY (item_id) REFERENCES item (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE lien_doodle');
    }
}

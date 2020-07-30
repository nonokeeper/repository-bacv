<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200611115948 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE doodle (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, description VARCHAR(255) DEFAULT NULL, max_personnes INT DEFAULT NULL, begin_date DATE DEFAULT NULL, end_date DATE DEFAULT NULL, active TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE item (id INT AUTO_INCREMENT NOT NULL, doodle_id INT DEFAULT NULL, name VARCHAR(50) NOT NULL, description VARCHAR(255) DEFAULT NULL, INDEX IDX_1F1B251EC9EC860E (doodle_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE personne (id INT AUTO_INCREMENT NOT NULL, doodle_id INT DEFAULT NULL, pseudo VARCHAR(255) NOT NULL, bureau TINYINT(1) DEFAULT NULL, INDEX IDX_FCEC9EFC9EC860E (doodle_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251EC9EC860E FOREIGN KEY (doodle_id) REFERENCES doodle (id)');
        $this->addSql('ALTER TABLE personne ADD CONSTRAINT FK_FCEC9EFC9EC860E FOREIGN KEY (doodle_id) REFERENCES doodle (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE item DROP FOREIGN KEY FK_1F1B251EC9EC860E');
        $this->addSql('ALTER TABLE personne DROP FOREIGN KEY FK_FCEC9EFC9EC860E');
        $this->addSql('DROP TABLE doodle');
        $this->addSql('DROP TABLE item');
        $this->addSql('DROP TABLE personne');
    }
}

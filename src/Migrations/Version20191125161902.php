<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191125161902 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE age_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user ADD age_category_id INT DEFAULT NULL, CHANGE active active TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649E1F4383B FOREIGN KEY (age_category_id) REFERENCES age_category (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649E1F4383B ON user (age_category_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649E1F4383B');
        $this->addSql('DROP TABLE age_category');
        $this->addSql('DROP INDEX IDX_8D93D649E1F4383B ON user');
        $this->addSql('ALTER TABLE user DROP age_category_id, CHANGE active active TINYINT(1) DEFAULT \'1\' NOT NULL');
    }
}

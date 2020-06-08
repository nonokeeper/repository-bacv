<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200526180558 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE question (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(50) DEFAULT NULL, active TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sondage (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(50) NOT NULL, description VARCHAR(255) DEFAULT NULL, active TINYINT(1) DEFAULT NULL, categorie VARCHAR(50) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sondage_user (sondage_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_39710E16BAF4AE56 (sondage_id), INDEX IDX_39710E16A76ED395 (user_id), PRIMARY KEY(sondage_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sondage_question (sondage_id INT NOT NULL, question_id INT NOT NULL, INDEX IDX_647D4C9BAF4AE56 (sondage_id), INDEX IDX_647D4C91E27F6BF (question_id), PRIMARY KEY(sondage_id, question_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sondage_user ADD CONSTRAINT FK_39710E16BAF4AE56 FOREIGN KEY (sondage_id) REFERENCES sondage (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sondage_user ADD CONSTRAINT FK_39710E16A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sondage_question ADD CONSTRAINT FK_647D4C9BAF4AE56 FOREIGN KEY (sondage_id) REFERENCES sondage (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sondage_question ADD CONSTRAINT FK_647D4C91E27F6BF FOREIGN KEY (question_id) REFERENCES question (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sondage_question DROP FOREIGN KEY FK_647D4C91E27F6BF');
        $this->addSql('ALTER TABLE sondage_user DROP FOREIGN KEY FK_39710E16BAF4AE56');
        $this->addSql('ALTER TABLE sondage_question DROP FOREIGN KEY FK_647D4C9BAF4AE56');
        $this->addSql('DROP TABLE question');
        $this->addSql('DROP TABLE sondage');
        $this->addSql('DROP TABLE sondage_user');
        $this->addSql('DROP TABLE sondage_question');
    }
}

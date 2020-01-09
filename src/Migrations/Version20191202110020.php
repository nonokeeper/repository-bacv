<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191202110020 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE team_veteran ADD capitaine_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE team_veteran ADD CONSTRAINT FK_34A73E082A10D79E FOREIGN KEY (capitaine_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_34A73E082A10D79E ON team_veteran (capitaine_id)');
        $this->addSql('ALTER TABLE team ADD capitaine_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE team ADD CONSTRAINT FK_C4E0A61F2A10D79E FOREIGN KEY (capitaine_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C4E0A61F2A10D79E ON team (capitaine_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE team DROP FOREIGN KEY FK_C4E0A61F2A10D79E');
        $this->addSql('DROP INDEX UNIQ_C4E0A61F2A10D79E ON team');
        $this->addSql('ALTER TABLE team DROP capitaine_id');
        $this->addSql('ALTER TABLE team_veteran DROP FOREIGN KEY FK_34A73E082A10D79E');
        $this->addSql('DROP INDEX UNIQ_34A73E082A10D79E ON team_veteran');
        $this->addSql('ALTER TABLE team_veteran DROP capitaine_id');
    }
}

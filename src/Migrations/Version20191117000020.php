<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191117000020 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE interclub_veteran ADD lieu_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE interclub_veteran ADD CONSTRAINT FK_21CAE2D46AB213CC FOREIGN KEY (lieu_id) REFERENCES lieu (id)');
        $this->addSql('CREATE INDEX IDX_21CAE2D46AB213CC ON interclub_veteran (lieu_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE interclub_veteran DROP FOREIGN KEY FK_21CAE2D46AB213CC');
        $this->addSql('DROP INDEX IDX_21CAE2D46AB213CC ON interclub_veteran');
        $this->addSql('ALTER TABLE interclub_veteran DROP lieu_id');
    }
}

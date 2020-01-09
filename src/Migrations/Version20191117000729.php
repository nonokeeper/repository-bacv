<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191117000729 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE club DROP FOREIGN KEY FK_B8EE38726AB213CC');
        $this->addSql('DROP INDEX IDX_B8EE38726AB213CC ON club');
        $this->addSql('DROP INDEX IDX_B8EE38725661BEF5 ON club');
        $this->addSql('ALTER TABLE club DROP lieu_id, DROP lieu2_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE club ADD lieu_id INT DEFAULT NULL, ADD lieu2_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE club ADD CONSTRAINT FK_B8EE38726AB213CC FOREIGN KEY (lieu_id) REFERENCES lieu (id)');
        $this->addSql('CREATE INDEX IDX_B8EE38726AB213CC ON club (lieu_id)');
        $this->addSql('CREATE INDEX IDX_B8EE38725661BEF5 ON club (lieu2_id)');
    }
}

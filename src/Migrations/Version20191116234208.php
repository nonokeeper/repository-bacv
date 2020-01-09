<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191116234208 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        //$this->addSql('ALTER TABLE club DROP FOREIGN KEY FK_B8EE38725661BEF5');
        //$this->addSql('DROP TABLE lieu2');
        //$this->addSql('ALTER TABLE interclub ADD lieu_id INT DEFAULT NULL');
        //$this->addSql('ALTER TABLE interclub ADD CONSTRAINT FK_890EAFC86AB213CC FOREIGN KEY (lieu_id) REFERENCES lieu (id)');
        //$this->addSql('CREATE INDEX IDX_890EAFC86AB213CC ON interclub (lieu_id)');
        //$this->addSql('ALTER TABLE club DROP INDEX UNIQ_B8EE38725661BEF5, ADD INDEX IDX_B8EE38725661BEF5 (lieu2_id)');
        //$this->addSql('ALTER TABLE club DROP INDEX UNIQ_B8EE38726AB213CC, ADD INDEX IDX_B8EE38726AB213CC (lieu_id)');
        //$this->addSql('ALTER TABLE club DROP FOREIGN KEY FK_B8EE38725661BEF5');
        //$this->addSql('ALTER TABLE club ADD CONSTRAINT FK_B8EE38725661BEF5 FOREIGN KEY (lieu2_id) REFERENCES lieu (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE lieu2 (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(30) NOT NULL COLLATE utf8mb4_unicode_ci, rue VARCHAR(50) NOT NULL COLLATE utf8mb4_unicode_ci, code_postal VARCHAR(5) NOT NULL COLLATE utf8mb4_unicode_ci, ville VARCHAR(30) NOT NULL COLLATE utf8mb4_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE club DROP INDEX IDX_B8EE38726AB213CC, ADD UNIQUE INDEX UNIQ_B8EE38726AB213CC (lieu_id)');
        $this->addSql('ALTER TABLE club DROP INDEX IDX_B8EE38725661BEF5, ADD UNIQUE INDEX UNIQ_B8EE38725661BEF5 (lieu2_id)');
        $this->addSql('ALTER TABLE club DROP FOREIGN KEY FK_B8EE38725661BEF5');
        $this->addSql('ALTER TABLE club ADD CONSTRAINT FK_B8EE38725661BEF5 FOREIGN KEY (lieu2_id) REFERENCES lieu2 (id)');
        $this->addSql('ALTER TABLE interclub DROP FOREIGN KEY FK_890EAFC86AB213CC');
        $this->addSql('DROP INDEX IDX_890EAFC86AB213CC ON interclub');
        $this->addSql('ALTER TABLE interclub DROP lieu_id');
    }
}

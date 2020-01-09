<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191217145701 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE team CHANGE mixte mixte TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE interclub ADD sh1_id INT DEFAULT NULL, ADD sh2_id INT DEFAULT NULL, ADD sh3_id INT DEFAULT NULL, ADD sh4_id INT DEFAULT NULL, ADD sd_id INT DEFAULT NULL, ADD ddjoueuse1_id INT DEFAULT NULL, ADD ddjoueuse2_id INT DEFAULT NULL, ADD dh1joueur1_id INT DEFAULT NULL, ADD dh1joueur2_id INT DEFAULT NULL, ADD dh2joueur1_id INT DEFAULT NULL, ADD dh2joueur2_id INT DEFAULT NULL, ADD dmxjoueur_id INT DEFAULT NULL, ADD dmxjoueuse_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE interclub ADD CONSTRAINT FK_890EAFC844A161A6 FOREIGN KEY (sh1_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE interclub ADD CONSTRAINT FK_890EAFC85614CE48 FOREIGN KEY (sh2_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE interclub ADD CONSTRAINT FK_890EAFC8EEA8A92D FOREIGN KEY (sh3_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE interclub ADD CONSTRAINT FK_890EAFC8737F9194 FOREIGN KEY (sh4_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE interclub ADD CONSTRAINT FK_890EAFC855141174 FOREIGN KEY (sd_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE interclub ADD CONSTRAINT FK_890EAFC8E961E301 FOREIGN KEY (ddjoueuse1_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE interclub ADD CONSTRAINT FK_890EAFC8FBD44CEF FOREIGN KEY (ddjoueuse2_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE interclub ADD CONSTRAINT FK_890EAFC877CFF221 FOREIGN KEY (dh1joueur1_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE interclub ADD CONSTRAINT FK_890EAFC8657A5DCF FOREIGN KEY (dh1joueur2_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE interclub ADD CONSTRAINT FK_890EAFC8EE2D9420 FOREIGN KEY (dh2joueur1_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE interclub ADD CONSTRAINT FK_890EAFC8FC983BCE FOREIGN KEY (dh2joueur2_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE interclub ADD CONSTRAINT FK_890EAFC861B44C89 FOREIGN KEY (dmxjoueur_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE interclub ADD CONSTRAINT FK_890EAFC83B66131E FOREIGN KEY (dmxjoueuse_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_890EAFC844A161A6 ON interclub (sh1_id)');
        $this->addSql('CREATE INDEX IDX_890EAFC85614CE48 ON interclub (sh2_id)');
        $this->addSql('CREATE INDEX IDX_890EAFC8EEA8A92D ON interclub (sh3_id)');
        $this->addSql('CREATE INDEX IDX_890EAFC8737F9194 ON interclub (sh4_id)');
        $this->addSql('CREATE INDEX IDX_890EAFC855141174 ON interclub (sd_id)');
        $this->addSql('CREATE INDEX IDX_890EAFC8E961E301 ON interclub (ddjoueuse1_id)');
        $this->addSql('CREATE INDEX IDX_890EAFC8FBD44CEF ON interclub (ddjoueuse2_id)');
        $this->addSql('CREATE INDEX IDX_890EAFC877CFF221 ON interclub (dh1joueur1_id)');
        $this->addSql('CREATE INDEX IDX_890EAFC8657A5DCF ON interclub (dh1joueur2_id)');
        $this->addSql('CREATE INDEX IDX_890EAFC8EE2D9420 ON interclub (dh2joueur1_id)');
        $this->addSql('CREATE INDEX IDX_890EAFC8FC983BCE ON interclub (dh2joueur2_id)');
        $this->addSql('CREATE INDEX IDX_890EAFC861B44C89 ON interclub (dmxjoueur_id)');
        $this->addSql('CREATE INDEX IDX_890EAFC83B66131E ON interclub (dmxjoueuse_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE interclub DROP FOREIGN KEY FK_890EAFC844A161A6');
        $this->addSql('ALTER TABLE interclub DROP FOREIGN KEY FK_890EAFC85614CE48');
        $this->addSql('ALTER TABLE interclub DROP FOREIGN KEY FK_890EAFC8EEA8A92D');
        $this->addSql('ALTER TABLE interclub DROP FOREIGN KEY FK_890EAFC8737F9194');
        $this->addSql('ALTER TABLE interclub DROP FOREIGN KEY FK_890EAFC855141174');
        $this->addSql('ALTER TABLE interclub DROP FOREIGN KEY FK_890EAFC8E961E301');
        $this->addSql('ALTER TABLE interclub DROP FOREIGN KEY FK_890EAFC8FBD44CEF');
        $this->addSql('ALTER TABLE interclub DROP FOREIGN KEY FK_890EAFC877CFF221');
        $this->addSql('ALTER TABLE interclub DROP FOREIGN KEY FK_890EAFC8657A5DCF');
        $this->addSql('ALTER TABLE interclub DROP FOREIGN KEY FK_890EAFC8EE2D9420');
        $this->addSql('ALTER TABLE interclub DROP FOREIGN KEY FK_890EAFC8FC983BCE');
        $this->addSql('ALTER TABLE interclub DROP FOREIGN KEY FK_890EAFC861B44C89');
        $this->addSql('ALTER TABLE interclub DROP FOREIGN KEY FK_890EAFC83B66131E');
        $this->addSql('DROP INDEX IDX_890EAFC844A161A6 ON interclub');
        $this->addSql('DROP INDEX IDX_890EAFC85614CE48 ON interclub');
        $this->addSql('DROP INDEX IDX_890EAFC8EEA8A92D ON interclub');
        $this->addSql('DROP INDEX IDX_890EAFC8737F9194 ON interclub');
        $this->addSql('DROP INDEX IDX_890EAFC855141174 ON interclub');
        $this->addSql('DROP INDEX IDX_890EAFC8E961E301 ON interclub');
        $this->addSql('DROP INDEX IDX_890EAFC8FBD44CEF ON interclub');
        $this->addSql('DROP INDEX IDX_890EAFC877CFF221 ON interclub');
        $this->addSql('DROP INDEX IDX_890EAFC8657A5DCF ON interclub');
        $this->addSql('DROP INDEX IDX_890EAFC8EE2D9420 ON interclub');
        $this->addSql('DROP INDEX IDX_890EAFC8FC983BCE ON interclub');
        $this->addSql('DROP INDEX IDX_890EAFC861B44C89 ON interclub');
        $this->addSql('DROP INDEX IDX_890EAFC83B66131E ON interclub');
        $this->addSql('ALTER TABLE interclub DROP sh1_id, DROP sh2_id, DROP sh3_id, DROP sh4_id, DROP sd_id, DROP ddjoueuse1_id, DROP ddjoueuse2_id, DROP dh1joueur1_id, DROP dh1joueur2_id, DROP dh2joueur1_id, DROP dh2joueur2_id, DROP dmxjoueur_id, DROP dmxjoueuse_id');
        $this->addSql('ALTER TABLE team CHANGE mixte mixte TINYINT(1) DEFAULT \'1\'');
    }
}

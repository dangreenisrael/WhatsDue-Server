<?php

namespace Whatsdue\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150814115216 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        /* Get rid of old settings */
        $this->addSql('ALTER TABLE fos_user DROP settings');

        /* Remove orphans */
        $this->addSql('DELETE FROM email_log WHERE user NOT IN (SELECT id FROM fos_user)');

        $this->addSql('ALTER TABLE email_log CHANGE user user INT DEFAULT NULL');
        $this->addSql('ALTER TABLE email_log ADD CONSTRAINT FK_6FB48838D93D649 FOREIGN KEY (user) REFERENCES fos_user (id)');
        $this->addSql('CREATE INDEX IDX_6FB48838D93D649 ON email_log (user)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE email_log DROP FOREIGN KEY FK_6FB48838D93D649');
        $this->addSql('DROP INDEX IDX_6FB48838D93D649 ON email_log');
        $this->addSql('ALTER TABLE email_log CHANGE user user VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
    }
}

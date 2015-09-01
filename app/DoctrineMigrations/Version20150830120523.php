<?php

namespace Whatsdue\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150830120523 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE assignment ADD customType TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE fos_user ADD referrer INT DEFAULT NULL');
        $this->addSql('ALTER TABLE fos_user ADD CONSTRAINT FK_957A6479ED646567 FOREIGN KEY (referrer) REFERENCES fos_user (id)');
        $this->addSql('CREATE INDEX IDX_957A6479ED646567 ON fos_user (referrer)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE assignment DROP customType');
        $this->addSql('ALTER TABLE fos_user DROP FOREIGN KEY FK_957A6479ED646567');
        $this->addSql('DROP INDEX IDX_957A6479ED646567 ON fos_user');
        $this->addSql('ALTER TABLE fos_user DROP referrer');
    }
}

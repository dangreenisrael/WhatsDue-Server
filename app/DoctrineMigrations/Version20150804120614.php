<?php

namespace Whatsdue\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150804120614 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE student CHANGE firstName firstName VARCHAR(50) DEFAULT NULL, CHANGE lastName lastName VARCHAR(50) DEFAULT NULL, CHANGE role role VARCHAR(50) DEFAULT NULL, CHANGE over12 over12 TINYINT(1) DEFAULT NULL, CHANGE parentEmail parentEmail VARCHAR(255) DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE student CHANGE firstName firstName VARCHAR(50) NOT NULL COLLATE utf8_unicode_ci, CHANGE lastName lastName VARCHAR(50) NOT NULL COLLATE utf8_unicode_ci, CHANGE role role VARCHAR(50) NOT NULL COLLATE utf8_unicode_ci, CHANGE over12 over12 TINYINT(1) NOT NULL, CHANGE parentEmail parentEmail VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
    }
}

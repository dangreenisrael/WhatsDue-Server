<?php

namespace Whatsdue\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Create and populate Consumers table
 */
class Version20150614070209 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql('CREATE TABLE Consumers (id INT AUTO_INCREMENT NOT NULL, devices VARCHAR(1000) NOT NULL, courses VARCHAR(1000) NOT NULL, notifications TINYINT(1) NOT NULL, notificationUpdates TINYINT(1) NOT NULL, notificationTime VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('INSERT INTO Consumers (id, devices) SELECT id, CONCAT("[",id,"]") FROM Students');

        $this->addSql('ALTER TABLE Students RENAME TO Devices');
        $this->addSql('ALTER TABLE Devices DROP institutionName');

        $this->addSql('ALTER TABLE Assignments CHANGE time_visible time_visible TINYINT(1) DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE Consumers');

        $this->addSql('ALTER TABLE Devices RENAME TO Students');
        $this->addSql('ALTER TABLE Students ADD institutionName TEXT NULL DEFAULT NULL ;');


        $this->addSql('ALTER TABLE Assignments CHANGE time_visible time_visible TINYINT(1) NOT NULL');
    }
}

<?php

namespace Whatsdue\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150630203813 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE ForumMessages');
        $this->addSql('DROP TABLE School');
        $this->addSql('DELETE FROM Assignments WHERE courseId < 47');
        $this->addSql('ALTER TABLE Assignments ADD CONSTRAINT FK_B616DF0AC2B73C54 FOREIGN KEY (courseId) REFERENCES Courses (id)');
        $this->addSql('CREATE INDEX IDX_B616DF0AC2B73C54 ON Assignments (courseId)');
        $this->addSql('ALTER TABLE Courses CHANGE schoolName schoolName LONGTEXT NOT NULL, CHANGE courseCode courseCode VARCHAR(10) DEFAULT NULL');
        $this->addSql('ALTER TABLE Devices CHANGE consumerId consumerId VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE Messages DROP username, CHANGE createdAt createdAt INT NOT NULL, CHANGE updatedAt updatedAt INT NOT NULL');
        $this->addSql('ALTER TABLE fos_user CHANGE username username VARCHAR(255) NOT NULL, CHANGE email email VARCHAR(255) NOT NULL, CHANGE salt salt VARCHAR(255) NOT NULL, CHANGE password password VARCHAR(255) NOT NULL, CHANGE settings settings VARCHAR(255) DEFAULT NULL, CHANGE username_canonical username_canonical VARCHAR(255) NOT NULL, CHANGE email_canonical email_canonical VARCHAR(255) NOT NULL, CHANGE roles roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', CHANGE first_name first_name VARCHAR(255) NOT NULL, CHANGE last_name last_name VARCHAR(255) NOT NULL, CHANGE institution_abbreviation institution_abbreviation VARCHAR(255) DEFAULT NULL, CHANGE institution_name institution_name VARCHAR(255) NOT NULL, CHANGE salutation salutation VARCHAR(255) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_957A647992FC23A8 ON fos_user (username_canonical)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_957A6479A0D96FBF ON fos_user (email_canonical)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE ForumMessages (id INT AUTO_INCREMENT NOT NULL, user_id VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, reference_id INT NOT NULL, type VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, body MEDIUMTEXT NOT NULL COLLATE utf8_unicode_ci, createdAt VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, updatedAt VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE School (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, city VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, region VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, country VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, address VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, contactName VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, contactEmail VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, contactPhone VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, archived TINYINT(1) NOT NULL, createdAt INT NOT NULL, lastModified INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE Assignments DROP FOREIGN KEY FK_B616DF0AC2B73C54');
        $this->addSql('DROP INDEX IDX_B616DF0AC2B73C54 ON Assignments');
        $this->addSql('ALTER TABLE Courses CHANGE courseCode courseCode VARCHAR(45) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE schoolName schoolName VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE Devices CHANGE consumerId consumerId TEXT DEFAULT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE Messages ADD username VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE createdAt createdAt VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE updatedAt updatedAt VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
        $this->addSql('DROP INDEX UNIQ_957A647992FC23A8 ON fos_user');
        $this->addSql('DROP INDEX UNIQ_957A6479A0D96FBF ON fos_user');
        $this->addSql('ALTER TABLE fos_user CHANGE username username VARCHAR(12) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE username_canonical username_canonical VARCHAR(10) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE email email VARCHAR(256) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE email_canonical email_canonical VARCHAR(256) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE salt salt VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE password password VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE roles roles LONGTEXT NOT NULL COLLATE utf8_unicode_ci, CHANGE settings settings LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE salutation salutation VARCHAR(10) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE first_name first_name VARCHAR(45) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE last_name last_name VARCHAR(45) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE institution_name institution_name VARCHAR(100) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE institution_abbreviation institution_abbreviation VARCHAR(45) DEFAULT NULL COLLATE utf8_unicode_ci');
    }
}

<?php

namespace Whatsdue\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150720094517 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE assignment CHANGE courseId courseId INT DEFAULT NULL');
        $this->addSql('ALTER TABLE course DROP FOREIGN KEY FK_661863D02D696931');
        $this->addSql('ALTER TABLE course DROP schoolName');
        $this->addSql('DROP INDEX idx_169e6fb92d696931 ON course');
        $this->addSql('CREATE INDEX IDX_169E6FB964B64DCC ON course (userId)');
        $this->addSql('ALTER TABLE course ADD CONSTRAINT FK_661863D02D696931 FOREIGN KEY (userId) REFERENCES fos_user (id)');
        $this->addSql('ALTER TABLE student DROP FOREIGN KEY FK_B723AF33B723AF33');
        $this->addSql('DROP INDEX IDX_B723AF33B723AF33 ON student');
        $this->addSql('ALTER TABLE student DROP student');
        $this->addSql('ALTER TABLE fos_user DROP institution_abbreviation');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE assignment CHANGE courseId courseId INT NOT NULL');
        $this->addSql('ALTER TABLE course DROP FOREIGN KEY FK_169E6FB964B64DCC');
        $this->addSql('ALTER TABLE course ADD schoolName LONGTEXT NOT NULL COLLATE utf8_unicode_ci');
        $this->addSql('DROP INDEX idx_169e6fb964b64dcc ON course');
        $this->addSql('CREATE INDEX IDX_169E6FB92D696931 ON course (userId)');
        $this->addSql('ALTER TABLE course ADD CONSTRAINT FK_169E6FB964B64DCC FOREIGN KEY (userId) REFERENCES fos_user (id)');
        $this->addSql('ALTER TABLE fos_user ADD institution_abbreviation VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE student ADD student INT DEFAULT NULL');
        $this->addSql('ALTER TABLE student ADD CONSTRAINT FK_B723AF33B723AF33 FOREIGN KEY (student) REFERENCES student_assignment (id)');
        $this->addSql('CREATE INDEX IDX_B723AF33B723AF33 ON student (student)');
    }
}

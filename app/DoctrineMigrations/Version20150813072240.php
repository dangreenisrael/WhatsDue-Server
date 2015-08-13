<?php

namespace Whatsdue\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150813072240 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE fos_user DROP pipedrive_deal, DROP pipedrive_person, DROP pipedrive_organization, DROP pipedrive_stage, DROP unique_followers, DROP unique_invitations, DROP total_courses, DROP total_assignments');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE fos_user ADD pipedrive_deal INT DEFAULT NULL, ADD pipedrive_person INT DEFAULT NULL, ADD pipedrive_organization INT DEFAULT NULL, ADD pipedrive_stage INT DEFAULT NULL, ADD unique_followers INT DEFAULT NULL, ADD unique_invitations INT DEFAULT NULL, ADD total_courses INT DEFAULT NULL, ADD total_assignments INT DEFAULT NULL');
    }
}

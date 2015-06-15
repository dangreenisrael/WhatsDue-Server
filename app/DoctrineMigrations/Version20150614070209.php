<?php

namespace Whatsdue\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Create and populate Consumers table
 */
class Version20150614070209 extends AbstractMigration implements ContainerAwareInterface
{

    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Students RENAME TO Devices');
        $this->addSql('ALTER TABLE Devices DROP institutionName');
        $this->addSql('ALTER TABLE Devices ADD consumerId TEXT');
        $this->addSql('UPDATE Devices SET consumerId=id');

        $this->addSql('CREATE TABLE Consumers (id INT AUTO_INCREMENT NOT NULL, devices VARCHAR(1000) NOT NULL, courses VARCHAR(1000) NOT NULL, notifications TINYINT(1) NOT NULL, notificationUpdates TINYINT(1) NOT NULL, notificationTime VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('INSERT INTO Consumers (id, devices) SELECT id, CONCAT("[",id,"]") FROM Devices');
        $this->addSql('UPDATE Consumers SET notifications=1');
        $this->addSql('UPDATE Consumers SET notificationUpdates=1');
        $this->addSql('UPDATE Consumers SET notificationTime="1700"');

        $this->addSql('ALTER TABLE Courses ADD consumerIds LONGTEXT DEFAULT NULL');

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

        $this->addSql('ALTER TABLE Devices DROP consumerId');
        $this->addSql('ALTER TABLE Devices RENAME TO Students');
        $this->addSql('ALTER TABLE Students ADD institutionName TEXT NULL DEFAULT NULL ;');

        $this->addSql('ALTER TABLE Assignments CHANGE time_visible time_visible TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE Courses DROP consumerIds');

    }


    public function postUp(Schema $schema)
    {
        $em = $this->container->get('doctrine')->getManager();
        $courses = $em->getRepository('WhatsdueMainBundle:Courses')->findAll();
        $deviceRepo = $em->getRepository('WhatsdueMainBundle:Device');
        foreach($courses as $course){
            $uuids = @json_decode($course->getDeviceIds(), true);
            $deviceIds = [];
            if ($uuids){
                foreach($uuids as $uuid){
                    $device = $deviceRepo->findOneBy(array("uuid"=>$uuid));
                    $deviceId = $device->getId();
                    $deviceIds[] = $deviceId;
                }
            }
            $course->setConsumerIds(json_encode($deviceIds));
        }
        $em->flush();
        echo "\nMigrated Device to Consumer \n";
    }

}

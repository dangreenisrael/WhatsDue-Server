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

        /*
         * Make table names lowercase
         */
        $this->addSql('RENAME TABLE Students TO student');
        $this->addSql('RENAME TABLE Assignments TO assignment');
        $this->addSql('RENAME TABLE Courses TO course');
        $this->addSql('RENAME TABLE Messages TO message');
        $this->addSql('RENAME TABLE EmailLog TO email_log');

        /*
         * Drop old tables
         */
        $this->addSql('ALTER TABLE acl_entries DROP FOREIGN KEY FK_46C8B806EA000B10');
        $this->addSql('ALTER TABLE acl_entries DROP FOREIGN KEY FK_46C8B8063D9AB4A6');
        $this->addSql('ALTER TABLE acl_object_identities DROP FOREIGN KEY FK_9407E54977FA751A');
        $this->addSql('ALTER TABLE acl_object_identity_ancestors DROP FOREIGN KEY FK_825DE2993D9AB4A6');
        $this->addSql('ALTER TABLE acl_object_identity_ancestors DROP FOREIGN KEY FK_825DE299C671CEA1');
        $this->addSql('ALTER TABLE acl_entries DROP FOREIGN KEY FK_46C8B806DF9183C9');
        $this->addSql('DROP TABLE acl_classes');
        $this->addSql('DROP TABLE acl_entries');
        $this->addSql('DROP TABLE acl_object_identities');
        $this->addSql('DROP TABLE acl_object_identity_ancestors');
        $this->addSql('DROP TABLE acl_security_identities');
        $this->addSql('DROP TABLE School');
        $this->addSql('DROP TABLE ForumMessages');

        /*
         * Remove old columns
         */
        $this->addSql('ALTER TABLE fos_user DROP institution_abbreviation');
        $this->addSql('ALTER TABLE course DROP schoolName');


        /*
         * Change old students to devices
         */
        $this->addSql('ALTER TABLE student RENAME TO device');
        $this->addSql('ALTER TABLE device DROP institutionName');
        $this->addSql('ALTER TABLE device ADD studentId INT NOT NULL');
        $this->addSql('UPDATE device SET studentId=id');

        /*
         * Setup new student table
         */
        $this->addSql('CREATE TABLE student (id INT AUTO_INCREMENT NOT NULL, notifications TINYINT(1) NOT NULL, notificationUpdates TINYINT(1) NOT NULL, notificationTimeLocal VARCHAR(255) NOT NULL, notificationTimeUTC VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('INSERT INTO student (id) SELECT id FROM device');
        $this->addSql('UPDATE student SET notifications=1');
        $this->addSql('UPDATE student SET notificationUpdates=1');
        $this->addSql('UPDATE student SET notificationTimeLocal="0000"');
        $this->addSql('UPDATE student SET notificationTimeUTC="0000"');
        $this->addSql('ALTER TABLE student ADD firstName VARCHAR(50) NOT NULL, ADD lastName VARCHAR(50) NOT NULL, ADD role VARCHAR(50) NOT NULL, ADD over12 TINYINT(1) NOT NULL, ADD parentEmail VARCHAR(255) NOT NULL, ADD signupDate VARCHAR(255) NOT NULL');

        /*
         * minor updates to assignment and message
         */
        $this->addSql('ALTER TABLE assignment CHANGE assignmentName assignmentName VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE assignment CHANGE time_visible time_visible TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE assignment CHANGE courseId courseId INT DEFAULT NULL');
        $this->addSql('ALTER TABLE message DROP username, CHANGE createdAt createdAt INT NOT NULL, CHANGE updatedAt updatedAt INT NOT NULL');

        /*
         * Setup join table course_student
         */
        $this->addSql('CREATE TABLE course_student (course_id INT NOT NULL, student_id INT NOT NULL, INDEX IDX_BFE0AADF591CC992 (course_id), INDEX IDX_BFE0AADFCB944F1A (student_id), PRIMARY KEY(course_id, student_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE course_student ADD CONSTRAINT FK_5D696B20CB944F1A FOREIGN KEY (student_id) REFERENCES student (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE course_student ADD CONSTRAINT FK_5D696B20F9295384 FOREIGN KEY (course_id) REFERENCES course (id) ON DELETE CASCADE');

        /*
         * Setup table for individual students' assignments
         */
        $this->addSql('CREATE TABLE student_assignment (id INT AUTO_INCREMENT NOT NULL, assignment INT DEFAULT NULL, student INT DEFAULT NULL, completed TINYINT(1) NULL, dateCompleted INT NULL, INDEX IDX_DD1AA95B30C544BA (assignment), INDEX IDX_DD1AA95BB723AF33 (student), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE student_assignment ADD CONSTRAINT FK_65C47AA3B723AF33 FOREIGN KEY (student) REFERENCES student (id)');
        $this->addSql('ALTER TABLE student_assignment ADD CONSTRAINT FK_65C47AA330C544BA FOREIGN KEY (assignment) REFERENCES assignment (id)');



        /*
        * Change Course username to user ID and drop username
        */
        $this->addSql('ALTER TABLE course ADD userId INT NOT NULL');
        $this->addSql('UPDATE course SET course.userId = (SELECT fos_user.id FROM fos_user WHERE fos_user.username =course.adminId)');
        $this->addSql('ALTER TABLE course DROP adminId ');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        echo "There's no going back from this one";
    }

    public function postUp(Schema $schema)
    {
        /*
         * Populate the course_student table
         */
        $em = $this->container->get('doctrine')->getManager();
        $course = $em->getRepository('WhatsdueMainBundle:Course')->findAll();
        $deviceRepo = $em->getRepository('WhatsdueMainBundle:Device');
        $studentRepo = $em->getRepository('WhatsdueMainBundle:Student');
        foreach($course as $course){
            $uuids = @json_decode($course->getDeviceIds(), true);
            if ($uuids){
                foreach($uuids as $uuid){
                    $device = $deviceRepo->findOneBy(array("uuid"=>$uuid));
                    $student = $studentRepo->find($device->getId());
                    $course->addStudent($student);
                }
            }
        }
        echo "\n Finished course_student \n";
        $em->flush();
        $em->clear();




    }
}
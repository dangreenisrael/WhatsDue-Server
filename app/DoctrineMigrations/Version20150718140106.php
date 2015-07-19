<?php

namespace Whatsdue\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Whatsdue\MainBundle\Entity\StudentAssignment;


/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150718140106 extends AbstractMigration implements ContainerAwareInterface
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



        /*
         * Get rid of all orphans
         */
        $this->addSql('DELETE FROM course WHERE userId NOT IN (SELECT id FROM fos_user)');
        $this->addSql('DELETE FROM assignment WHERE courseId NOT IN (SELECT id FROM course)');

        /*
         * Set foreign keys and indexes
         */
        $this->addSql('ALTER TABLE fos_user CHANGE username username VARCHAR(255) NOT NULL, CHANGE email email VARCHAR(255) NOT NULL, CHANGE salt salt VARCHAR(255) NOT NULL, CHANGE password password VARCHAR(255) NOT NULL, CHANGE settings settings VARCHAR(255) DEFAULT NULL, CHANGE username_canonical username_canonical VARCHAR(255) NOT NULL, CHANGE email_canonical email_canonical VARCHAR(255) NOT NULL, CHANGE roles roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', CHANGE first_name first_name VARCHAR(255) NOT NULL, CHANGE last_name last_name VARCHAR(255) NOT NULL, CHANGE institution_abbreviation institution_abbreviation VARCHAR(255) DEFAULT NULL, CHANGE institution_name institution_name VARCHAR(255) NOT NULL, CHANGE salutation salutation VARCHAR(255) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_957A647992FC23A8 ON fos_user (username_canonical)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_957A6479A0D96FBF ON fos_user (email_canonical)');

        $this->addSql('ALTER TABLE assignment CHANGE assignmentName assignmentName VARCHAR(50) NOT NULL');
        $this->addSql('CREATE INDEX IDX_30C544BAC2B73C54 ON assignment (courseId)');
        $this->addSql('ALTER TABLE assignment ADD CONSTRAINT FK_B616DF0AC2B73C54 FOREIGN KEY (courseId) REFERENCES course (id)');

        $this->addSql('ALTER TABLE course CHANGE schoolName schoolName LONGTEXT NOT NULL, CHANGE courseCode courseCode VARCHAR(10) DEFAULT NULL');
        $this->addSql('ALTER TABLE course ADD CONSTRAINT FK_661863D02D696931 FOREIGN KEY (userId) REFERENCES fos_user (id)');
        $this->addSql('CREATE INDEX IDX_169E6FB92D696931 ON course (userId)');

        $this->addSql('ALTER TABLE device ADD CONSTRAINT FK_DEBA770698BF2F98 FOREIGN KEY (studentId) REFERENCES student (id)');
        $this->addSql('CREATE INDEX IDX_92FB68E98BF2F98 ON device (studentId)');

        $this->addSql('ALTER TABLE student ADD CONSTRAINT FK_B723AF33B723AF33 FOREIGN KEY (student) REFERENCES student_assignment (id)');
        $this->addSql('CREATE INDEX IDX_B723AF33B723AF33 ON student (student)');

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
         echo "There's no going back from this one";
    }

    public function postUp(Schema $schema){
        /*
         * Populate the student_assignments table
         */
        $em = $this->container->get('doctrine')->getManager();
        $assignments = $this->container->get('doctrine')->getManager()->getRepository('WhatsdueMainBundle:Assignment')->findAll();
        $i=0;
        $ii=0;
        foreach ($assignments as $assignment){
            $students = $assignment->getCourse()->getStudents();
            foreach ($students as $student){
                $i++;
                $ii++;
                $studentAssignment = new StudentAssignment();
                $studentAssignment->setStudent($student);
                $studentAssignment->setAssignment($assignment);
                $em->merge($studentAssignment);
            }
            if ($i>=1000){
                $i=0;
                $em->flush();
                $em->clear();
                echo "\nFlushed $ii";
            }
        }
        $em->flush();
        $em->clear();
        echo "\nFlushed $ii\n";
        echo "Finished student_assignments";
    }

}
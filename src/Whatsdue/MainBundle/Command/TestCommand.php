<?php
/**
 * Created by PhpStorm.
 * User: Dan
 * Date: 4/19/15
 * Time: 12:37
 */

namespace Whatsdue\MainBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Whatsdue\MainBundle\Entity\StudentAssignment;

class TestCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('task')
            ->setDescription('random tasks');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
        $assignments = $this->getContainer()->get('doctrine')->getManager()->getRepository('WhatsdueMainBundle:Assignment')->findAll();
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
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
use Doctrine\Common\Util\Debug;

class RemoveOrphanStudentAssignmentsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('RemoveOrphanStudentAssignments')
            ->setDescription('Remove StudentAssignments from when someone removed a course')
        ;
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
        $studentAssignments = $em->getRepository('WhatsdueMainBundle:StudentAssignment')->findAll();
        $i=0;
        $ii=0;
        foreach($studentAssignments as $studentAssignment){
            $i++;
            $student = $studentAssignment->getStudent();
            $studentId = $student->getId();
            $course = $studentAssignment->getAssignment()->getCourse();
            $studentList = [];
            foreach($course->getStudents() as $student){
                $studentList[] = $student->getId();
            }
            $studentList = array_values($studentList);
            $inCourse = in_array($studentId, $studentList);
            if (!$inCourse) {
                $ii++;
//                $student->removeStudentAssignment($studentAssignment);
//                $studentAssignment->getAssignment()->removeStudentAssignment($studentAssignment);
                $em->remove($studentAssignment);
                if (($ii % 1000) === 0) {
                    $em->flush();
                    echo "$ii\n";
                }
            }

        }
        echo "$i Records\n";
        echo "$ii Orphans\n";
        $em->flush();
        $em->clear();
        $output->writeln("Finished");
    }
}
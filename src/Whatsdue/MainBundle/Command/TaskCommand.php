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
use Doctrine\Common\Util\Debug;


class TaskCommand extends ContainerAwareCommand
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
        $assignments = $em->getRepository('WhatsdueMainBundle:Assignment')->findAll();
        $courseRepo = $em->getRepository('WhatsdueMainBundle:Course');
        foreach ($assignments as $assignment){
            $course = $courseRepo->find($assignment->getCourseId());
            $assignment->addCourse($course);
        }
        $em->flush();
        echo "Finished course_assignment\n";
    }
}
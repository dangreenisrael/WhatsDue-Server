<?php
/**
 * Created by PhpStorm.
 * User: Dan
 * Date: 4/19/15
 * Time: 12:37
 * Description: This deals with updating users to pipedrive
 */

namespace Whatsdue\MainBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class UserStatsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('WhatsDue:UserStats')
            ->setDescription('Move people into has users stage on pipedrive')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();
        $em = $container->get('doctrine')->getManager();
        $userRepository = $em->getRepository('WhatsdueMainBundle:User');
        $courseRepository = $container->get('doctrine')->getRepository('WhatsdueMainBundle:Courses');
        $assignmentRepository = $container->get('doctrine')->getRepository('WhatsdueMainBundle:Assignments');
        $users = $userRepository->findAll();
        $i=0;

        foreach ($users as $user){
            $i++;
            $courses = $courseRepository->findBy(
                array('adminId'  => $user->getUsername(), 'archived' => 0)
            );
            /* Total Unique Users */
            $deviceIds = [];
            foreach ($courses as $course){
                $currentDeviceIds = json_decode($course->getDeviceIds(), true);
                $deviceIds = @array_merge($deviceIds, $currentDeviceIds);
            }
            $uniqueUsers = @array_unique($deviceIds);
            $assignments = $assignmentRepository->findBy(
                array('adminId'  => $user->getUsername())
            );

            $totalCourses       = count($courses);
            $totalAssignments   = count($assignments);
            $totalUniqueFollowers   = count($uniqueUsers);

            $user->setUniqueFollowers($totalUniqueFollowers);
            $user->setTotalCourses($totalCourses);
            $user->setTotalAssignments($totalAssignments);

            $dealId  = $user->getPipedriveDeal();
            if ($totalUniqueFollowers >= 3){
                $container->get('pipedrive')->updateDeal($user, 5);
                echo $user->getUsername()."\n";
            }
        }
        echo "Processed Stats\n\nBeginning Pipedrive:\n\n";
        $em->flush();

        foreach ($users as $user){
            $container->get('pipedrive')->updatePerson($user);
            $response = $container->get('pipedrive')->updateDeal($user, $user->getPipedriveStage());
            echo $user->getId()." $response \n";
        }


        $text = "Sorting Complete";
        $output->writeln($text);
    }
}
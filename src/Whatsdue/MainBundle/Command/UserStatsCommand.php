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

class UserStatsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('WhatsDue:UserStats')
            ->setDescription('Stats')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();
        $em = $container->get('doctrine')->getManager();
        $userRepository = $em->getRepository('WhatsdueMainBundle:User');
        $courseRepository = $container->get('doctrine')->getRepository('WhatsdueMainBundle:Course');
        $assignmentRepository = $container->get('doctrine')->getRepository('WhatsdueMainBundle:Assignment');
        $emailLogRepository = $container->get('doctrine')->getRepository('WhatsdueMainBundle:EmailLog');
        $users = $userRepository->findAll();
        $i=0;

        foreach ($users as $user){
            $i++;
            $courses = $courseRepository->findBy(
                array('adminId'  => $user->getUsername(), 'archived' => 0)
            );
            /* Total Unique Users */
            $totalFollowers = [];
            foreach ($courses as $course){
                $followers = json_decode($course->getConsumerIds(), true);
                $totalFollowers = @array_merge($totalFollowers, $followers);
            }
            $uniqueFollowers = @array_unique($totalFollowers);
            $assignments = $assignmentRepository->findBy(
                array('adminId'  => $user->getUsername())
            );

            /* Total Unique Email Recipients */
            $emailLogs = $emailLogRepository->findBy(array(
                "user"=>$user->getId()
            ));
            if (!$emailLogs) {
                $uniqueRecipients = 0;
            } else{
                unset($recipients);
                $recipients = array();
                foreach ($emailLogs as $emailLog){
                    $recipients = array_merge($recipients, json_decode($emailLog->getRecipients()));
                }
                $uniqueRecipients = count(array_unique($recipients));
            }


            $totalCourses       = count($courses);
            $totalAssignments   = count($assignments);
            $totalUniqueFollowers   = count($uniqueFollowers);

            $user->setUniqueFollowers($totalUniqueFollowers);
            $user->setTotalCourses($totalCourses);
            $user->setTotalAssignments($totalAssignments);
            $user->setUniqueInvitations($uniqueRecipients);



            echo $user->getId() ." ".$user->getFirstName()." ".$user->getLastName();
        }
        echo "Processed Stats";
        $em->flush();
        $text = "Sorting Complete";
        $output->writeln($text);
    }
}
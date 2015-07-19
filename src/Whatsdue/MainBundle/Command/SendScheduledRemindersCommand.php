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
use Moment\Moment;



class SendScheduledRemindersCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('sendReminders')
            ->setDescription('Send Scheduled Reminders')
            ->addOption(
                'params',
                null,
                InputOption::VALUE_NONE,
                'If set, we will test parameters'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if ($input->getOption('params')) {
             $this->testParameters();
        }
        $em = $this->getContainer()->get('doctrine')->getManager();
        $consumersRepo = $em->getRepository('WhatsdueMainBundle:Consumer');
        $assignmentsRepo = $em->getRepository('WhatsdueMainBundle:Assignment');
        $tomorrow = $moment = new Moment();
        $tomorrow->addDays(1)->format('Y-m-d');
        $dayAfterTomorrow = $moment = new Moment();
        $dayAfterTomorrow->addDays(2)->format('Y-m-d');

        /* Get the time rounded down to the last 15min (sanity check) */
        $seconds = time();
        $rounded_seconds = floor($seconds / (15 * 60)) * (15 * 60);
        $notificationTime = date("Hi", $rounded_seconds);

        /* Get the Consumers to potentially be notified */
        $consumerQuery = $consumersRepo->createQueryBuilder('c')
            ->where('c.notificationTimeUtc = :notificationTime')
            ->setParameter('notificationTime', $notificationTime)
            ->getQuery();
        $consumers = $consumerQuery->getResult();
        $consumers = $consumersRepo->findById(515);

        /* Make a list of consumers to be reminded */
        $notificationList = [];
        foreach ($consumers as $consumer){
            $courses = $consumer->getCourses();
            $courseIds = json_decode($courses, true);
            $assignmentsQuery = $assignmentsRepo->createQueryBuilder('c')
                ->where('c.courseId IN (:courseIds)')
                ->setParameter('courseIds', $courseIds)
                ->andWhere('c.dueDate > :tomorrow')
                ->andWhere('c.dueDate < :dayAfterTomorrow')
                ->setParameter(':tomorrow', $tomorrow)
                ->setParameter(':dayAfterTomorrow', $dayAfterTomorrow)
                ->getQuery();
            $assignments = $assignmentsQuery->getResult();
            $notificationList[] = $consumer;
        }

        /* Send the notifications */
        $title = "Don't forget to check WhatsDue";
        $message = "You have things to get done for tomorrow";
        $this->getContainer()->get('push_notifications')->sendNotifications($title, $message, $consumers);
    }

    protected function testParameters(){
        echo $this->getContainer()->getParameter('pipedrive.apiKey');
        echo "\n";
        return null;
    }
}
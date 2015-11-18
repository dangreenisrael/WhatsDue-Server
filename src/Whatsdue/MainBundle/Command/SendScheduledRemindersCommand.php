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
use Moment\Moment;
use Doctrine\Common\Util\Debug;
use Doctrine\Common\Collections\Criteria;
use JMS\Serializer\SerializerBuilder;

class SendScheduledRemindersCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('sendReminders')
            ->setDescription('Send Scheduled Reminders')
            ->addArgument(
                'user',
                InputArgument::OPTIONAL,
                'Who to send to?'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $em = $this->getContainer()->get('doctrine')->getManager();
        $studentsRepo = $em->getRepository('WhatsdueMainBundle:Student');
        $tomorrow = $moment = new Moment();
        $tomorrow = $tomorrow->addDays(1)->format('Y-m-d');
        $dayAfterTomorrow = $moment = new Moment();
        $dayAfterTomorrow = $dayAfterTomorrow->addDays(2)->format('Y-m-d');

        /* Get the time rounded down to the last 15min up and down */
        $seconds = time();
        $rounded_seconds = floor($seconds / (15 * 60)) * (15 * 60);
        $notificationTimeLower = date("Hi", $rounded_seconds);
        $notificationTimeUpper = new Moment($notificationTimeLower, 'UTC');
        $notificationTimeUpper = $notificationTimeUpper->addMinutes(15)->format('Hi');

        /* Get the Consumers to potentially be notified */
        $studentQuery = $studentsRepo->createQueryBuilder('q')
            ->where('q.notificationTimeUtc < :notificationTimeUpper')
            ->setParameter('notificationTimeUpper', $notificationTimeUpper)
            ->andWhere('q.notificationTimeUtc >= :notificationTimeLower')
            ->setParameter('notificationTimeLower', $notificationTimeLower)
            ->andWhere('q.notifications = true')
            ->andWhere('q.notificationTimeUtc != 0000')
            ->getQuery();
        $students = $studentQuery->getResult();

        if ($id = $input->getArgument('user')){
            $students = array($studentsRepo->find($id));
        }

        /* Process each student */
        foreach ($students as $student){
            /* Make a list of assignments that have not been completed */
            $criteria = Criteria::create()
                ->where(Criteria::expr()->eq("completed", false))
                ->orWhere(Criteria::expr()->eq("completed", null));
            $studentAssignments = $student->getStudentAssignments()->matching($criteria);

            $tomorrowCount = 0;
            $afterTomorrowCount = 0;
            foreach ($studentAssignments as $studentAssignment){
                $dueDate = $studentAssignment->getAssignment()->getDueDate();
                $dueTomorrow = ($dueDate > $tomorrow) && ($dueDate < $dayAfterTomorrow);
                $dueAfterTomorrow = ($dueDate >= $dayAfterTomorrow);
                if ($dueTomorrow) $tomorrowCount++;
                if ($dueAfterTomorrow) $afterTomorrowCount++;
            }
            echo "tomorrow: $tomorrowCount, future: $afterTomorrowCount";
            /* Send the notifications */
            if ($afterTomorrowCount == 1){
                $message[0] = "You have 1 item due after tomorrow";
            } elseif ($afterTomorrowCount){
                $message[0] = "You have $afterTomorrowCount items due after tomorrow";
            } else{
                $message[0] = "You have nothing due after tomorrow";
            }

            if ($tomorrowCount == 1){
                $message[1] = "You have 1 item due tomorrow";
            } elseif ($tomorrowCount){
                $message[1] = "You have $tomorrowCount item due tomorrow";
            } else{
                $message[1] = "You have nothing due tomorrow";
            }

            if ($tomorrowCount > 0 || $afterTomorrowCount > 0){
                $this->getContainer()->get('push_notifications')->sendNotifications($message, array($student));
            }
        }
    }
}
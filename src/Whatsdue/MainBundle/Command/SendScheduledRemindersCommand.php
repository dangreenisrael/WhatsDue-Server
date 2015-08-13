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
        $studentsRepo = $em->getRepository('WhatsdueMainBundle:Student');
        $tomorrow = $moment = new Moment();
        $tomorrow = $tomorrow->addDays(1)->format('Y-m-d');
        $dayAfterTomorrow = $moment = new Moment();
        $dayAfterTomorrow = $dayAfterTomorrow->addDays(2)->format('Y-m-d');

        /* Get the time rounded down to the last 15min up and down */
        $seconds = time();
        $rounded_seconds = floor($seconds / (15 * 60)) * (15 * 60);
        $notificationTimeLower = date("Hi", $rounded_seconds);
        $notificationTimeUpper = new Moment($notificationTimeLower, 'U');
        $notificationTimeUpper = $notificationTimeUpper->addMinutes(15)->format('Hi');

        /* Get the Consumers to potentially be notified */
        $studentQuery = $studentsRepo->createQueryBuilder('q')
            ->where('q.notificationTimeUtc < :notificationTimeUpper')
            ->setParameter('notificationTimeUpper', $notificationTimeUpper)
            ->andWhere('q.notificationTimeUtc >= :notificationTimeLower')
            ->setParameter('notificationTimeLower', $notificationTimeLower)
            ->getQuery();
        $students = $studentQuery->getResult();
        //  $students = $studentsRepo->findById(3714);

        //debug::dump($students);
        //exit;
        /* Make a list of consumers to be reminded */
        $notificationList = [];
        foreach ($students as $student){
            /* Make a list of assignments that have not been completed */
            $criteria = Criteria::create()
                ->where(Criteria::expr()->eq("completed", false))
                ->orWhere(Criteria::expr()->eq("completed", null));
            $studentAssignments = $student->getStudentAssignments()->matching($criteria);

            /* Make a list of those assignments that are due tomorrow*/
            foreach ($studentAssignments as $studentAssignment){
                $dueDate = $studentAssignment->getAssignment()->getDueDate();
                $somethingTomorrow = ($dueDate > $tomorrow) && ($dueDate < $dayAfterTomorrow);
                if ($somethingTomorrow){
                    $notificationList[] = $student;
                    echo $student->getFirstName(). " ". $student->getLastName()."\n";
                    break;
                }
            }
        }
        //debug::dump($notificationList);

        /* Send the notifications */
        $title = "Don't forget to check WhatsDue";
        $message = "You have things to get done for tomorrow";
        $this->getContainer()->get('push_notifications')->sendNotifications($title, $message, $students);
    }


}
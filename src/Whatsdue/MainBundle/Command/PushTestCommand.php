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

class PushTestCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('pushTest')
            ->setDescription('Send Test Notifications')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $em = $this->getContainer()->get('doctrine')->getManager();
        $studentsRepo = $em->getRepository('WhatsdueMainBundle:Student');
        $student = array($studentsRepo->find(3715));
        $title = "Test";
        $message = "The notification system works";
        $this->getContainer()->get('push_notifications')->sendNotifications($title, $message, $student);
    }
}
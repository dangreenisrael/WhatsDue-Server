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
            ->addArgument(
                'studentId'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $studentId = $input->getArgument('studentId');
        $em = $this->getContainer()->get('doctrine')->getManager();
        $studentRepo = $em->getRepository('WhatsdueMainBundle:Student');
        $student = $studentRepo->find($studentId);
        $message = "single";
        $this->getContainer()->get('push_notifications')->sendNotifications($message, array($student));
    }
}
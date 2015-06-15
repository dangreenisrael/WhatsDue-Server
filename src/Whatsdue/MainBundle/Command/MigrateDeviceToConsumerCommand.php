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

class MigrateDeviceToConsumerCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('WhatsDue:Migrate:DeviceToConsumer')
            ->setDescription('Migrate Course data from deviceId to consumerId')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
        $courses = $em->getRepository('WhatsdueMainBundle:Courses')->findAll();
        $deviceRepo = $em->getRepository('WhatsdueMainBundle:Device');
        foreach($courses as $course){
            $uuids = @json_decode($course->getDeviceIds(), true);
            $deviceIds = [];
            if ($uuids){
                foreach($uuids as $uuid){
                    $device = $deviceRepo->findOneBy(array("uuid"=>$uuid));
                    $deviceId = $device->getId();
                    $deviceIds[] = $deviceId;
                }
            }
            $course->setConsumerIds(json_encode($deviceIds));
        }
        $em->flush();
        $output->writeln("Finished");
    }

    protected function testParameters(){
        echo $this->getContainer()->getParameter('pipedrive.apiKey');
        echo "\n";
        return null;
    }
}
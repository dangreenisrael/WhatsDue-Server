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

class MigrateToForeignKeyCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('WhatsDue:PopulateStudentCourses')
            ->setDescription('Clean out foreign key issues')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
        $course = $em->getRepository('WhatsdueMainBundle:Course')->findAll();
        $deviceRepo = $em->getRepository('WhatsdueMainBundle:Device');
        $studentRepo = $em->getRepository('WhatsdueMainBundle:Student');
        foreach($course as $course){
            $uuids = @json_decode($course->getDeviceIds(), true);
            if ($uuids){
                foreach($uuids as $uuid){
                    $device = $deviceRepo->findOneBy(array("uuid"=>$uuid));
                    $student = $studentRepo->find($device->getId());
                    $course->addStudent($student);
                }
            }
        }
        echo "\nMigrated Device to Consumer \n";
        $em->flush();
    }

    protected function testParameters(){
        echo $this->getContainer()->getParameter('pipedrive.apiKey');
        echo "\n";
        return null;
    }
}
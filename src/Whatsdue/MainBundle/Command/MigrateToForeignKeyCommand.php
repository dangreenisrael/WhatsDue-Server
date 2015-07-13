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
            ->setName('WhatsDue:Migrate:ForeignKey')
            ->setDescription('Clean out foreign key issues')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
        $assignments = $em->getRepository('WhatsdueMainBundle:Assignments')->findAll();
        $courseRepo = $em->getRepository('WhatsdueMainBundle:Courses');
        foreach($assignments as $assignment){
            $parentCourse = $courseRepo->find($assignment->getCourseId());
            //var_dump($parentCourse->getId());

            if (!$parentCourse){
                echo  $assignment->getCourseId()."\n";
            }
        }
        $output->writeln("Finished");
    }

    protected function testParameters(){
        echo $this->getContainer()->getParameter('pipedrive.apiKey');
        echo "\n";
        return null;
    }
}
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

class PipedriveCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('pipedrive:users')
            ->setDescription('Move people into has users stage on pipedrive')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();
        $em = $container->get('doctrine')->getManager();
        $userRepository = $em->getRepository('WhatsdueMainBundle:User');
        $courseRepository = $container->get('doctrine')->getRepository('WhatsdueMainBundle:Courses');

        /* Get a list of teachers aren't flagged as having users yet */
        $teachers = $userRepository->findBy(array(
            'hasUsers'=>null
        ));

        /* Check if they have users now, and if they do - update them to pipedrive */
        foreach($teachers as $teacher){
            $courses = $courseRepository->findBy(array(
                'adminId'=>$teacher->getUsername()
            ));
            foreach ($courses as $course){
                $userCount = count(json_decode($course->getDeviceIds(), true));
                $dealId  = $teacher->getPipedriveDeal();
                if ($userCount >= 3){
                    $container->get('pipedrive')->updateDeal($dealId, 5);
                    $teacher->setHasUsers(true);
                    echo $teacher->getUsername()."\n";
                    break;
                }
            }
            //$user->setHasUsers(null);
        }
        $em->flush();
        $text = "Sorting Complete";
        $output->writeln($text);
    }
}
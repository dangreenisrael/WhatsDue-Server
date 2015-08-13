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

class DeleteDanCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('DeleteDan')
            ->setDescription('Delete me from the DB for testing purposes')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
        $deviceRepo = $em->getRepository('WhatsdueMainBundle:Device');
        $deviceByPushId = $deviceRepo->findOneBy(array('pushId'=> '1bad98e1dc1de3e837986d909f8fb791bc0ff3545d732a3bf9fe23007b3cb1e1'));
        $deviceByUuid = $deviceRepo->findOneBy(array('uuid'=> '3432A2FB-52F2-4844-996D-300F25EFF071'));
        if ($deviceByPushId){
            $student = $deviceByPushId->getStudent();
            foreach ($student->getStudentAssignments() as $assignments) {
                $em->remove($assignments);
            }
            $em->remove($deviceByPushId);
            $em->remove($student);

        }
        if($deviceByUuid){
            $student = $deviceByUuid->getStudent();
            foreach ($student->getStudentAssignments() as $assignments) {
                $em->remove($assignments);
            }
            $em->remove($deviceByUuid);
            $em->remove($student);
        }
        $em->flush();
        $output->writeln("<info>Deleted Dan</info>");

    }
}
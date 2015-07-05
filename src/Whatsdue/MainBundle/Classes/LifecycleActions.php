<?php
/**
 * Created by PhpStorm.
 * User: dan
 * Date: 2014-05-16
 * Time: 1:05 PM
 */

namespace Whatsdue\MainBundle\Classes;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Whatsdue\MainBundle\Entity\Courses;
use Whatsdue\MainBundle\Entity\Assignments;
use Whatsdue\MainBundle\Entity\User;
use Whatsdue\MainBundle\Classes\PushNotifications;

/*
 * Push notifications are dealt with here
 */
class LifecycleActions {

    protected $container;
    protected $pushNotifications;
    protected $request;

    public function __construct(ContainerInterface $container){
        $this->container = $container;
        $this->pushNotifications = new PushNotifications($container);
        $this->request = new Request();
    }

    public function getContainer(){
        return $this->container;
    }

    public function getAdminID () {
        return $this->getContainer()->get('security.context')->getToken()->getUser();
    }

    private function getDatetime(){
        $date = new \DateTime();
        return $date->format('Y-m-d\TH:i:sP');
    }


    public function prePersist(LifeCycleEventArgs $args){

    }

    public function postPersist(LifeCycleEventArgs $args){
        $entity = $args->getEntity();
        $em = $args->getEntityManager();

        if ($entity instanceof Assignments) {
            $course = $this->container->get('doctrine')->getManager()->getRepository('WhatsdueMainBundle:Courses')->find($entity->getCourseId());
            $title = $course->getCourseName();
            $message = "New assignment: ".$entity->getAssignmentName(). ', from '.$title;
            $consumerIDs = json_decode($course->getConsumerIds(), true);
            $this->pushNotifications->sendChangeNotifications($title, $message, $consumerIDs);
        }

        if ($entity instanceof User) {
            $message = "A new user signed up - " .
                $entity -> getFirstName() . " " . $entity -> getLastName();
            $this->container->get('plivo')->sendSMS('+972507275599', $message);

            /*
             * Make set username as Id
             */


            $userId = $entity->getId();
            $entity->setUsername($userId);
            $entity->setUsernameCanonical($userId);
            $entity->setSignupDate($this->getDatetime());
            $em->persist($entity);
            $em->flush();

            /* Create Pipedrive Person/Org/Deal */
            $this->container->get('pipedrive')->newTeacher($entity);

        }
    }

    public function preUpdate(LifeCycleEventArgs $args){
        $entity = $args->getEntity();
        if ($entity instanceof Assignments) {

            $id = $entity->getCourseId();

            $course = $this->container->get('doctrine')->getManager()->getRepository('WhatsdueMainBundle:Courses')->find($id);

            /* Send Push Notifications */
            $assignment_id = $entity->getId();
            if ($entity->getArchived() == true){
                $title = 'Assignment Removed';
                $message = $entity->getAssignmentName() . ' from ' . $course->getCourseName() . ' was removed.';

            }else {
                $title = 'Assignment Updated';
                $message = $entity->getAssignmentName() . ' from ' . $course->getCourseName() . ' was updated.';
            }
            $consumerIDs = json_decode($course->getConsumerIds(), true);
            $this->pushNotifications->sendChangeNotifications($title, $message, $consumerIDs);
        }
    }
}

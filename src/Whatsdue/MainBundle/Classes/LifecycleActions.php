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
use Whatsdue\MainBundle\Entity\Course;
use Whatsdue\MainBundle\Entity\Assignment;
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

        if ($entity instanceof Assignment) {
            if (!$entity->getIsBulk()){
                $course = $entity->getCourse();
                $title = $course->getCourseName();
                $message = "New assignment: ".$entity->getAssignmentName(). ', from '.$title;
                $this->pushNotifications->sendChangeNotifications( $message, $course->getStudents());
            }
        }

        if ($entity instanceof User) {
            $message = "A new user signed up - " .
                $entity -> getFirstName() . " " . $entity -> getLastName();
            $this->container->get('plivo')->sendSMS('+972507275599', $message);

            /* Set username as ID */
            $userId = $entity->getId();
            $entity->setUsername($userId);
            $entity->setUsernameCanonical($userId);

            /* Set signup date */
            $entity->setSignupDate($this->getDatetime());

            /* Deal with referrer */
            $referrer = &$_SESSION['referrer'];
            if ($referrer){
                $referrer = $this->container->get('doctrine')->getRepository('WhatsdueMainBundle:User')->find($referrer);
                $entity->setReferrer($referrer);
                unset($_SESSION['referrer']);
            }

            $em->persist($entity);
            $em->flush();
        }
    }

    public function postUpdate(LifeCycleEventArgs $args){
        $entity = $args->getEntity();

        if ($entity instanceof Assignment) {

            $course = $entity->getCourse();
            /* Send Push Notifications */
            if ($entity->getArchived() == true){
                $title = 'Assignment Removed';
                $message = $entity->getAssignmentName() . ' from ' . $course->getCourseName() . ' was removed.';

            }else {
                $title = 'Assignment Updated';
                $message = $entity->getAssignmentName() . ' from ' . $course->getCourseName() . ' was updated.';
            }
            $this->pushNotifications->sendChangeNotifications($message, $course->getStudents());
        }
    }
}

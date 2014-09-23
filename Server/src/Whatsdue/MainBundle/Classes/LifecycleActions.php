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
use Whatsdue\MainBundle\Classes\PushNotifications;

class LifecycleActions {

    protected $container;
    protected $notifications;
    protected $request;

    public function __construct(ContainerInterface $container){
        $this->container = $container;
        $this->notifications = new PushNotifications();
        $this->request = new Request();
    }

    public function getContainer(){
        return $this->container;
    }

    public function getAdminID () {
        return $this->getContainer()->get('security.context')->getToken()->getUser();
    }

    public function prePersist(LifeCycleEventArgs $args){
        $entity = $args->getEntity();

        if (($entity instanceof Assignments) || ($entity instanceof Courses)){
            /** UserId is recorded for ALL entries **/
            $adminId = $this->getAdminID();
            $entity->setAdminId($adminId);
        }

        if ($entity instanceof Assignments) {
           // $entity->setCourseName($_SESSION['courseName']);
            //$entity->setCourseId($_SESSION['courseId']);
            $course = $this->container->get('doctrine')->getManager()->getRepository('WhatsdueMainBundle:Courses')->find($entity->getCourseId());
            /* Send Push Notifications */
            $title = $entity->getAssignmentName();
            $message = $entity->getDescription();
            $tickerText = "New assignment for ".$title;
            $androidIds = unserialize($course->getAndroidUsers());
            $this->notifications->androidNotifications($title, $message, $tickerText, $androidIds, false, false);
        }
    }

    public function preUpdate(LifeCycleEventArgs $args){
        $entity = $args->getEntity();

        if ($entity instanceof Assignments) {
            $id = $entity->getCourseId();
            $course = $this->container->get('doctrine')->getManager()->getRepository('WhatsdueMainBundle:Courses')->find($id);
            /* Send Push Notifications */
            $assignment_id = $entity->getId();
            $title = "Assignment Update for ". $course->getCourseName();
            $message = $entity->getAssignmentName();
            $tickerText = "Updated assignment for ".$course->getCourseName();
            $androidIds = unserialize($course->getAndroidUsers());
            $this->notifications->androidNotifications($title, $message, $tickerText, $androidIds, true, $assignment_id);
        }
    }
}

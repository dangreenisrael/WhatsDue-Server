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


    public function prePersist(LifeCycleEventArgs $args){
        $entity = $args->getEntity();

        if (($entity instanceof Assignments) || ($entity instanceof Courses)){
            /** UserId is recorded for ALL entries **/
            $adminId = $this->getAdminID();
            $entity->setAdminId($adminId);
        }

        if ($entity instanceof Assignments) {
            $course = $this->container->get('doctrine')->getManager()->getRepository('WhatsdueMainBundle:Courses')->find($entity->getCourseId());
            $title = $course->getCourseName();
            $message = "New assignment: ".$entity->getAssignmentName(). ', from '.$title;
            $deviceIds = json_decode($course->getDeviceIds());
            $this->pushNotifications->sendNotifications($title, $message, $deviceIds);
        }

    }

    public function postPersist(LifeCycleEventArgs $args){
        $entity = $args->getEntity();
        $em = $args->getEntityManager();

        if ($entity instanceof User) {
            $message = "A new user signed up - " .
                $entity -> getFirstName() . " " . $entity -> getLastName() .
                " from " . $entity->getInstitutionName();
            $this->container->get('plivo')->sendSMS('+972507275599', $message);

            /*
             * Make set username as Id
             */

            $userId = $entity->getId();
            $entity->setUsername($userId);
            $entity->setUsernameCanonical($userId);
            $em->persist($entity);
            $em->flush();

            /*
             * Send the user an email letting them know they are in the system
             */

            $subject    = "Welcome to WhatsDue";
            $from       = "aaron@whatsdueapp.com";
            $recipients = $entity->getEmail();
            $firstName = $entity->getFirstName();
            $body = "
Hi $firstName,

I really appreciate you signing up for WhatsDue.

I hope it helps you and your students.

If you wouldn’t mind, I’d love it if you answered one, quick question: Why did you sign up for WhatsDue?

I’m asking because knowing why you signed up will help us make sure we’re delivering what our users want.

Just hit “reply” and let me know!

Thanks
Aaron

--
Aaron Taylor
Co-founder, WhatsDue
+972-50-7275599
whatsdueapp.com
            ";
            $mailer = $this->container->get('mailer');
            /* Send Email */
            $message = $mailer->createMessage()
                ->setSubject($subject)
                ->setFrom($from)
                ->setTo($recipients)
                ->setBody($body)
            ;
            $mailer->send($message);
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
            $deviceIds = json_decode($course->getDeviceIds());
            $this->pushNotifications->sendNotifications($title, $message, $deviceIds);
        }
    }
}

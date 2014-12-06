<?php
/**
 * Created by PhpStorm.
 * User: dan
 * Date: 2014-12-01
 * Time: 11:29 AM
 */

namespace Whatsdue\MainBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations\View;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\Controller\FOSRestController;
use Whatsdue\MainBundle\Entity\Messages;
use Whatsdue\MainBundle\Entity\Students;

use Whatsdue\MainBundle\Classes\PushNotifications;


class AdminController extends FOSRestController{

    public function getHeader($header){
        $request = Request::createFromGlobals();
        return $request->headers->get($header);
    }

    /**
     * @return array
     * @View()
     */
    public function getUsersAction(){
        $userRepository = $this->getDoctrine()->getRepository('WhatsdueMainBundle:User');
        $assignmentRepository = $this->getDoctrine()->getRepository('WhatsdueMainBundle:Assignments');
        $courseRepository = $this->getDoctrine()->getRepository('WhatsdueMainBundle:Courses');

        $users = $userRepository->findAll();

        $i = 0;
        foreach ($users as $user){
            $i++;
            $courses = $courseRepository->findBy(
                array('adminId'  => $user->getUsername(), 'archived' => 0)
            );
            /* Total Unique Users */
            $deviceIds = [];
            foreach ($courses as $course){
                $currentDeviceIds = json_decode($course->getDeviceIds(), true);
                $deviceIds = array_merge($deviceIds, $currentDeviceIds);
            }
            $uniqueUsers = array_unique($deviceIds);
            $assignments = $assignmentRepository->findBy(
                array('adminId'  => $user->getUsername())
            );

            $teachers[$i] = array(
                'id'                => $user->getId(),
                'username'          => $user->getUsername(),
                'email'             => $user->getEmailCanonical(),
                'last_login'        => $user->getLastLogin(),
                'course_count'      => count($courses),
                'assignment_count'  => count($assignments),
                'unique_users'      => count($uniqueUsers)
            );
        }

        return array("users" => array_values($teachers));
    }

    /*
     * Messages Stuff
     */

    /**
     * @return array
     * @View()
     */
    public function optionsMessagesAction(){
        return null;
    }

    /**
     * @return array
     * @View()
     * Send message to ALL users
     */
    public function postMessageAction( Request $request ){
        $username = $this->getUser()->getUsername();
        $data = json_decode($request->getContent());
        $title = $data->message->title;
        $body = $data->message->body;
        $message = new Messages();
        $message->setCourseId(0);
        $message->setTitle($title);
        $message->setBody($body);
        $message->setUsername($username);
        $em = $this->getDoctrine()->getManager();
        $em->persist($message);
        $em->flush();

        $studentRepository = $this->getDoctrine()->getRepository('WhatsdueMainBundle:Students');
        $allStudents = $studentRepository->findAll();
        $allUuids = array();
        foreach ($allStudents as $student){
            $allUuids[] = $student->getUuid();
        }

        $pushNotifications = $mailer = $this->get('push_notifications');
        $pushNotifications->sendNotifications($title, $body, $allUuids);
        //$pushNotifications->sendNotifications($title, $body, array('39cd2c28c433efca'));

        return array('message'=>$message);
    }
}

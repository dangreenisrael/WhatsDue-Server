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
use Whatsdue\MainBundle\Entity\User;

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
                array('adminId'  => $user->getUsername(0), 'archived' => 0)
            );
            $assignments = $assignmentRepository->findBy(
                array('adminId'  => $user->getUsername(0))
            );
            $teachers[$i] = array(
                'id'                => $user->getId(),
                'username'          => $user->getUsername(),
                'email'             => $user->getEmailCanonical(),
                'last_login'        => $user->getLastLogin(),
                'course_count'      => count($courses),
                'assignment_count'  => count($assignments)
            );
        }

        return array("users" => array_values($teachers));
    }
}

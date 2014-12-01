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
use Whatsdue\MainBundle\Entity\Students;
use Whatsdue\MainBundle\Entity\Assignments;
use Whatsdue\MainBundle\Entity\Courses;
use Whatsdue\MainBundle\Entity\Messages;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\Controller\FOSRestController;

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
    public function getCoursesAction(){
        $username = $this->getUser()->getUsername();
        $repository = $this->getDoctrine()->getRepository('WhatsdueMainBundle:Courses');
        $courses = $repository->findByAdminId($username);
        return array("courses"=>$courses);
    }

}
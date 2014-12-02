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
        $repository = $this->getDoctrine()->getRepository('WhatsdueMainBundle:User');
        $users = $repository->findAll();
        $i = 0;
        foreach ($users as $user){
            $i++;
            $teachers[$i]['id'] = $user->getId();
            $teachers[$i]['username'] = $user->getUsername();
            $teachers[$i]['email'] = $user->getEmailCanonical();
            $teachers[$i]['last_login'] = $user->getLastLogin();
        }

        return array("users" => array_values($teachers));
    }
}

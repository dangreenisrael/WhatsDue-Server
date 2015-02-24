<?php
/**
 * Created by PhpStorm.
 * User: dan
 * Date: 2014-07-08
 * Time: 7:26 PM
 */

namespace Whatsdue\MainBundle\Classes;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

class Helpers {


    public $container;

    public function __construct(ContainerInterface $container){
            $this->container = $container;
        }

    public function loginUser($username, $password){

        /* Validate the User */
        $user_manager = $this->container->get('fos_user.user_manager');
        $factory = $this->container->get('security.encoder_factory');
        $user = $user_manager->loadUserByUsername($username);
        $encoder = $factory->getEncoder($user);
        $validated = $encoder->isPasswordValid($user->getPassword(),$password,$user->getSalt());
        if (!$validated) {
            http_response_code(400);
            return false;
        } else {
            $token = new UsernamePasswordToken($user, null, "main", $user->getRoles());
            $this->container->get("security.context")->setToken($token); //now the user is logged in

            //now dispatch the login event
            $request = $this->container->get("request");
            $event = new InteractiveLoginEvent($request, $token);
            $this->container->get("event_dispatcher")->dispatch("security.interactive_login", $event);
            return true;
        }
    }

    public function authorizeUser($username){
        $user = $this->container->get('security.context')->getToken()->getUser();
        if ($username != $user->getUsername()){
            http_response_code(400);
            echo "Unauthorized";
            exit;
        }
    }

    public function getSchoolsList(){

            $schoolRepository = $this->container->get('doctrine.orm.entity_manager')->getRepository('WhatsdueMainBundle:School');
            $schools = $schoolRepository->findAll();
            $schoolNames=array();
            foreach ($schools as $school){
                $schoolNames[$school->getName()] = $school->getName();
            }
        return $schoolNames;

    }

} 
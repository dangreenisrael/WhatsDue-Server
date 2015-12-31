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
use Unirest;

class Helpers {


    public $container;

    public function __construct(ContainerInterface $container){
            $this->container = $container;
        }

    public function loginUser($username, $password){

        $securityContext = $this->container->get('security.context');
        if ($securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $securityContext->getToken()->getUser();
        }

        /* Validate the User */
        $user = $this->container->get('fos_user.user_manager')->findUserByUsernameOrEmail($username);
        $factory = $this->container->get('security.encoder_factory');
//        if (!$user){
//            echo "Validation Failed";
//            exit;
//        }

        $encoder = $factory->getEncoder($user);
        $validated = $encoder->isPasswordValid($user->getPassword(),$password,$user->getSalt());

        if (!$validated) {
            http_response_code(401);
            echo "Validation Failed";
            exit;
        } else {
            $token = new UsernamePasswordToken($user, null, "main", $user->getRoles());
            $this->container->get("security.context")->setToken($token); //now the user is logged in

            //now dispatch the login event
            $request = $this->container->get("request");
            $event = new InteractiveLoginEvent($request, $token);
            $this->container->get("event_dispatcher")->dispatch("security.interactive_login", $event);

            return $user;
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

    public function createCourseCode(){
        $length = 6;
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        /*
         * We are using a loop to 5 because anything greater that that would likely be an error
         */
        for ($i=0; $i<5; $i++ ){
            $courseCode = '';
            for ($i = 0; $i < $length; $i++) {
                $courseCode .= $characters[rand(0, $charactersLength - 1)];
            }
            $courseRepository = $this->container->get('doctrine.orm.entity_manager')->getRepository('WhatsdueMainBundle:Course');
            if(! $courseRepository->findOneBy(array('courseCode' => $courseCode))){
                return $courseCode;
            }
        }
    }

    public function getUserDateTime(){

        $ip = $_SERVER['REMOTE_ADDR'];
        if ($ip == "127.0.0.1"){
            $ip = "212.179.28.34";
        }

        /* Get the timezone from the IP */
        $response = Unirest\Request::get("https://worldtimeiodeveloper.p.mashape.com/ip?ipaddress=$ip",
            array(
                "X-Mashape-Key" => "0LFdQKu0owmsh00j6X6BfBg1h9mvp1qWbXyjsnVinhfmyPrBWm",
                "Accept" => "application/json"
            )
        );

        /* Get the user's time in JavaScript format*/
        $ISO8601 = 'Y-m-d\TH:i:sP';
        $timezone = timezone_name_from_abbr($response->body->current->abbreviation);

        $date = new \DateTime();

        $date->setTimezone(new \DateTimeZone($timezone));
        return $date->format($ISO8601);

    }

} 
<?php
/**
 * Created by PhpStorm.
 * User: dan
 * Date: 2014-04-14
 * Time: 11:59 AM
 */

namespace Whatsdue\MainBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations\View;
use Whatsdue\MainBundle\Entity\Assignments;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;

header("Access-Control-Allow-Origin: * ");
header("Access-Control-Allow-Headers: course, accept, content-type");
header("Access-Control-Allow-Method: GET, POST, OPTION");

class RestController extends Controller{

    public function getHeader($header){
        $request = Request::createFromGlobals();
        return $request->headers->get($header);
    }

    public function timestamp(){
        $date = new \DateTime();
        return $date->format('U');
    }

    /******* Get a list of Courses ********/
    /**
     * @return array
     * @View()
     */
    public function optionsAllCoursesAction(){
        return null;

    }
    /**
     * @return array
     * @View()
     */
    public function getAllCoursesAction(){
        $courses = $this->getDoctrine()->getRepository('WhatsdueMainBundle:Courses')
            ->findAll();

        $data = array(
            "course"=>$courses,
            "meta"=>array(
                "timestamp"=> $this->timestamp()
            )
        );
        return $data;
    }





    /******* Get Assignments by ID: json array of course IDs ********/
    /**
     * @return array
     * @View()
     */

    public function getAssignmentsAction(){
        $courses = json_decode($this->getHeader('courses'));
        $assignments = $this->getDoctrine()->getRepository('WhatsdueMainBundle:Assignments')
            ->findBy( array(
                'courseName' => $courses
            ));
        $data = array(
            "assignment"=>$assignments,
            "meta"=>array(
                "timestamp"=> $this->timestamp()
            )
        );
        return $data;
    }

}
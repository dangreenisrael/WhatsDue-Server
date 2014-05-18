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
header("Access-Control-Allow-Headers: courses, accept, content-type, timestamp");
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
        $courses = $this->getDoctrine()->getRepository('WhatsdueMainBundle:Courses');
        $timestamp = json_decode($this->getHeader('timestamp'));

        $query = $courses->createQueryBuilder('p')
            ->where('p.lastModified > :timestamp')
            ->setParameter('timestamp', $timestamp)
            ->getQuery();

        $products = $query->getResult();

        $data = array(
            "course"=>$products,
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
    public function optionsAssignmentsAction(){
        return null;

    }

    public function filterAssignments($assignment){
        $timestamp = json_decode($this->getHeader('timestamp'));
        return ($assignment->getLastModified() > $timestamp);
    }
    /**
     * @return array
     * @View()
     */

    public function getAssignmentsAction(){
        $courses = json_decode($this->getHeader('courses'));
        $assignments = $this->getDoctrine()->getRepository('WhatsdueMainBundle:Assignments')
            ->findBy( array(
                'courseId' => $courses
            ));

        $assignments = array_filter($assignments, array($this, 'filterAssignments'));

        $data = array(
            "assignment"=>$assignments,
            "meta"=>array(
                "timestamp"=> $this->timestamp()
            )
        );
        return $data;
    }

}
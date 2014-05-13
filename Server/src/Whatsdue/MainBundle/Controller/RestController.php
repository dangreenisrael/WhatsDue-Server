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
header("Access-Control-Allow-Origin: *");

class RestController extends Controller{

    /**
     * @return array
     * @View()
     */
    public function getUsersAction(){
        $users = $this->getDoctrine()->getRepository('WhatsdueMainBundle:Assignments')
            ->findAll();


        foreach ($users as $key => $value){
            $usersList[] = $value->getAdminID();
        }
        $usersList = array_unique($usersList);
        return array_unique($usersList);

    }

    /**
     * @return array
     * @View()
     */
    public function getAllCoursesAction(){
        $courses = $this->getDoctrine()->getRepository('WhatsdueMainBundle:Assignments')
            ->findAll();
        foreach ($courses as $key => $value){
            $coursesList[] = array(
                "id"                => $value->getId(),
                "courseId"          => $value->getCourseID(),
                "courseDescription" => $value->getCourseDescription(),
                "adminID"           => $value->getAdminID()
            );
        }
        $coursesList = array_map("unserialize", array_unique(array_map("serialize", $coursesList)));

        foreach ($coursesList as $courses){
            $sequentialList[] = $courses;
        }

        return array("course"=>$sequentialList);

    }

    /**
     * @return array
     * @View()
     */

    public function getUserCoursesAction($adminID){
        $courses = $this->getDoctrine()->getRepository('WhatsdueMainBundle:Assignments')
            ->findBy(array(
                'adminID'=>$adminID
            ));

        foreach ($courses as $key => $value){
            $coursesList[] = array(
                "courseId"          => $value->getCourseID(),
                "courseDescription" => $value->getCourseDescription(),
                "adminID"           => $adminID)
            ;
        }
        $coursesList = array_map("unserialize", array_unique(array_map("serialize", $coursesList)));

        foreach ($coursesList as $courses){
            $sequentialList[] = $courses;
        }
        return $sequentialList;

    }

    /**
     * @return array
     * @View()
     */

    public function getUserAssignmentsAction($adminID, $courseID){
        $assignments = $this->getDoctrine()->getRepository('WhatsdueMainBundle:Assignments')
            ->findBy(array(
                'adminID'   => $adminID,
                'courseID'  => $courseID
            ));


        return $assignments;

    }

    /**
     * @return array
     * @View()
     */

    public function getAllAssignmentsAction(){
        $assignments = $this->getDoctrine()->getRepository('WhatsdueMainBundle:Assignments')
            ->findAll();
        return $assignments;

    }

}
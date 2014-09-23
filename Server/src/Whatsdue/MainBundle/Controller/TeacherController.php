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
use Whatsdue\MainBundle\Entity\Students;
use Whatsdue\MainBundle\Entity\Assignments;
use Whatsdue\MainBundle\Entity\Courses;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Routing\ClassResourceInterface;

class TeacherController extends Controller{


    public function getHeader($header){
        $request = Request::createFromGlobals();
        return $request->headers->get($header);
    }

    /*
     * Courses Stuff
     */

    /**
     * @return array
     * @View()
     */
    public function optionsCoursesAction(){
        return null;
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

    /**
     * @return array
     * @View()
     */
    public function postCourseAction(Request $request ){
        $username = $this->getUser()->getUsername();
        $data = json_decode($request->getContent());
        $course = new Courses();
        $course->setCourseName($data->course->course_name);
        $course->setInstructorName($data->course->instructor_name);
        $course->setAdminId($username);
        $em = $this->getDoctrine()->getManager();
        $em->persist($course);
        $em->flush();

        return array('course'=>$course);
    }

    /**
     * @return array
     * @View()
     */
    public function putCourseAction($Id, Request $request){
        $data = json_decode($request->getContent());
        $em = $this->getDoctrine()->getManager();
        $record = $em->getRepository('WhatsdueMainBundle:Courses')->find($Id);
        $record->setCourseName($data->course->course_name);
        $record->setInstructorName($data->course->instructor_name);
        $em->flush();
        return array("assignment"=>$record);
    }

    /**
     * @return array
     * @View()
     */
    public function getCourseAction($Id, Request $request){
        $em = $this->getDoctrine()->getManager();
        $record = $em->getRepository('WhatsdueMainBundle:Courses')->find($Id);
        return $record;
    }


    /*
     * Assignments Stuff
     */

    /**
     * @return array
     * @View()
     */
    public function optionsAssignmentsAction(){
        return null;
    }

    /**
     * @return array
     * @View()
     */
    public function getAssignmentsAction(){
        $username = $this->getUser()->getUsername();
        $repository = $this->getDoctrine()->getRepository('WhatsdueMainBundle:Assignments');
        $assignments = $repository->findByAdminId($username);
        return array("assignment" => $assignments);
    }

    /**
     * @return array
     * @View()
     */
    public function postAssignmentsAction( Request $request ){
        $username = $this->getUser()->getUsername();
        $data = json_decode($request->getContent());
        $assignment = new Assignments();
        $assignment->setAssignmentName($data->assignment->assignment_name);
        $assignment->setCourseId($data->assignment->course_id);
        $assignment->setDescription(" ");
        $assignment->setAdminId($username);
        $assignment->setDueDate($data->assignment->due_date);
        $em = $this->getDoctrine()->getManager();
        $em->persist($assignment);
        $em->flush();

        return array('assignment'=>$assignment);
    }

    /**
     * @return array
     * @View()
     */
    public function putAssignmentsAction($Id, Request $request){
        $data = json_decode($request->getContent());
        $em = $this->getDoctrine()->getManager();
        $record = $em->getRepository('WhatsdueMainBundle:Assignments')->find($Id);
        $record->setDueDate($data->assignment->due_date);
        $record->setAssignmentName($data->assignment->assignment_name);

        $em->flush();
        return array('assignment' => $record);
    }

    /**
     * @return array
     * @View()
     */
    public function getAssignmentAction($Id, Request $request){
        $em = $this->getDoctrine()->getManager();
        $record = $em->getRepository('WhatsdueMainBundle:Assignments')->find($Id);
        return array('assignment' => $record);
    }
}
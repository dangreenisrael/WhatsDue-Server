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
use Whatsdue\MainBundle\Entity\Messages;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\Controller\FOSRestController;

use Whatsdue\MainBundle\Classes\PushNotifications;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;




class TeacherController extends FOSRestController implements ContainerAwareInterface{

    public function __construct(){

    }

    public function setContainer(\Symfony\Component\DependencyInjection\ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function getHeader($header){
        $request = Request::createFromGlobals();
        return $request->headers->get($header);
    }

    /**
     * @return array
     * @View()
     */
    public function postLoginAction(){

        $securityContext = $this->container->get('security.authorization_checker');
        if ($securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            echo "Authenticated";
            // authenticated REMEMBERED, FULLY will imply REMEMBERED (NON anonymous)
        }   else{
            header("HTTP/1.1 403 Unauthorized");
            echo "Not Authenticated";
        }
        return array();
    }

    /*
     * Courses Stuff
     */
    /**
     * @return array
     * @View()
     */
    public function getUserAction(){

        $user = $this->getUser();
        $user = array(
            'id'                  => $user->getId(),
            'username_canonical'  => $user->getUsernameCanonical(),
            'first_name'          => $user->getFirstName()
        );
        return array("user" => $user);
    }

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
        $user = $this->getUser();
        $username = $user->getUsername();
        $school = $user->getInstitutionName();
        $data = json_decode($request->getContent());
        $course = new Courses();
        $course->setCourseName($data->course->course_name);
        $course->setInstructorName($data->course->instructor_name);
        $course->setAdminId($username);
        $course->setDeviceIds('{}');
        $course->setSchoolName($school);
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
        $record->setArchived($data->course->archived);
        $em->flush();
        return array("course"=>$record);
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

    /**
     * @return array
     * @View()
     */
    public function getCourseAssignmentsAction($courseId, Request $request){
        $em = $this->getDoctrine()->getManager();
        $record = $em->getRepository('WhatsdueMainBundle:Assignments')
            ->findBy(
                array('courseId' => $courseId)
            );
        return $record;
    }


    /**
     * @return array
     * @View()
     */
    public function deleteCourseAction($Id){
        $em = $this->getDoctrine()->getManager();
        $record = $em->getRepository('WhatsdueMainBundle:Courses')->find($Id);
        $record->setArchived(true);
        $em->flush();
        return $this->view('', 204);
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
        $assignment->setDescription($data->assignment->description);
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
        $record->setDescription($data->assignment->description);
        $record->setAssignmentName($data->assignment->assignment_name);
        $record->setArchived($data->assignment->archived);

        $em->flush();
        return array('assignment' => $record);
    }

    /**
     * @return array
     * @View()
     */
    public function deleteAssignmentsAction($Id){
        $em = $this->getDoctrine()->getManager();
        $record = $em->getRepository('WhatsdueMainBundle:Assignments')->find($Id);
        $record->setArchived(true);
        $em->flush();

        return $this->view('', 204);
    }


    /**
     * @return array
     * @View()
     */
    public function getAssignmentAction($Id){
        $em = $this->getDoctrine()->getManager();
        $record = $em->getRepository('WhatsdueMainBundle:Assignments')->find($Id);
        return array('assignment' => $record);
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
     */
    public function getMessagesAction(){
        $username = $this->getUser()->getUsername();
        $repository = $this->getDoctrine()->getRepository('WhatsdueMainBundle:Messages');
        $messages = $repository->findByUsername($username);
        return array("message" => $messages);
    }

    /**
     * @return array
     * @View()
     */
    public function postMessagesAction( Request $request ){
        $username = $this->getUser()->getUsername();
        $data = json_decode($request->getContent());
        $message = new Messages();
        $message->setCourseId($data->message->course_id);
        $message->setTitle('');
        $message->setBody($data->message->body);
        $message->setUsername($username);
        $em = $this->getDoctrine()->getManager();
        $em->persist($message);
        $em->flush();
        return array('message'=>$message);
    }

    /*
     * Settings
     */

    /**
     * @return array
     * @View()
     */
    public function getSettingsAction($setting){
        $settingsSerialized = $this->getUser()->getSettings();
        $settings = json_decode(stripslashes($settingsSerialized),true);
        if (@$setting = $settings[$setting]){
            return $setting;
        }else{
            return " ";
        }
    }

    /**
     * @return array
     * @View()
     */

    public function putSettingsAction($settingPair){
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('WhatsdueMainBundle:User')->find($this->getUser()->getId());
        $settingsSerialized = $user->getSettings();
        $settings = json_decode(stripslashes($settingsSerialized),true);
        $settingPair = explode("-",$settingPair);
        $settingName = $settingPair[0];
        $settingValue = $settingPair[1];
        $settings[$settingName] = $settingValue;
        $settingsSerialized = json_encode($settings);
        $user->setSettings($settingsSerialized);
        $em->flush();
        return $settings;
    }
}
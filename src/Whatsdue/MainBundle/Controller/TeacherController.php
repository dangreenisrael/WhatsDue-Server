<?php
/**
 * Created by PhpStorm.
 * User: dan
 * Date: 2014-04-14
 * Time: 11:59 AM
 */

namespace Whatsdue\MainBundle\Controller;


use Doctrine\Common\Collections;
use Doctrine\Common\Util\Debug;
use FOS\RestBundle\Controller\Annotations\View;
use Whatsdue\MainBundle\Entity\Assignment;
use Whatsdue\MainBundle\Entity\Course;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\FOSRestController;


class TeacherController extends FOSRestController {


    public function __construct(){
        $username = $this->container->get('request')->headers->get("key");
        $password = $this->container->get('request')->headers->get("secret");
        $this->container->get('helper')->loginUser($username, $password);
    }


    public function getHeader($header){
        $request = Request::createFromGlobals();
        return $request->headers->get($header);
    }

    public function createCourseCode(){
        return $courseCode = $this->container->get('helper')->createCourseCode();
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
        $user = $this->currentUser($this);
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
        $courses = $this->currentUser($this)->getCourses();
        return array("courses"=>$courses);
    }

    /**
     * @return array
     * @View()
     */
    public function postCourseAction(Request $request ){
        $user = $this->currentUser($this);
        $username = $user->getUsername();
        $school = $user->getInstitutionName();
        $data = json_decode($request->getContent());
        $course = new Course();
        $course->setCourseName($data->course->course_name);
        $course->setInstructorName($data->course->instructor_name);
        $course->setAdminId($username);
        $course->setDeviceIds('{}');
        $course->setCourseCode($this->createCourseCode());
        $course->setSchoolName($school);
        $em = $this->getDoctrine()->getManager();
        $em->persist($course);
        $em->flush();


        $this->container->get('pipedrive')->updateDeal($user, 2);

        return array('course'=>$course);
    }

    /**
     * @return array
     * @View()
     */
    public function putCourseAction($Id, Request $request){
        $data = json_decode($request->getContent());
        $em = $this->getDoctrine()->getManager();
        $course = $em->getRepository('WhatsdueMainBundle:Course')->find($Id);
        /*Authorize*/
        $this->authorizeUser($this, $course->getAdminId());

        $course->setCourseName($data->course->course_name);
        $course->setInstructorName($data->course->instructor_name);
        $course->setArchived($data->course->archived);
        $em->flush();

        return array("course"=>$course);
    }

    /**
     * @return array
     * @View()
     */
    public function getCourseAction($courseId){
        $em = $this->getDoctrine()->getManager();
        $course = $em->getRepository('WhatsdueMainBundle:Course')->find($courseId);

        /*Authorize*/
        if($this->currentUser($this)->getId() != $course->getUser()->getId()) exit;
        return array("course" => $course);
    }

    /**
     * @return array
     * @View()
     */
    public function getCourseAssignmentsAction($courseId){
        $em = $this->getDoctrine()->getManager();
        $assignments = $em->getRepository('WhatsdueMainBundle:Assignment')
            ->findBy(
                array('courseId' => $courseId)
            );

        /*Authorize*/
        $course = $em->getRepository('WhatsdueMainBundle:Course')->find($courseId);
        $this->authorizeUser($this, $course->getAdminId());

        return array("assignment" => $assignments);
    }


    /**
     * @return array
     * @View()
     */
    public function deleteCourseAction($Id){
        $em = $this->getDoctrine()->getManager();
        $course = $em->getRepository('WhatsdueMainBundle:Course')->find($Id);
        /*Authorize*/
        $this->authorizeUser($this, $course->getAdminId());


        $course->setArchived(true);
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

        $username = $this->currentUser($this)->getUsername();
        $repository = $this->getDoctrine()->getRepository('WhatsdueMainBundle:Assignment');
        $assignments = $repository->findByAdminId($username);
        foreach ($assignments as $assignment){
            //$assignment->setCourse(null);
        }
        return array("assignment" => $assignments);
    }

    /**
     * @return array
     * @View()
     */
    public function postAssignmentsAction( Request $request ){
        $user = $this->currentUser($this);
        $username = $user->getUsername();
        $em = $this->getDoctrine()->getManager();
        $data = json_decode($request->getContent());

        $this->container->get('pipedrive')->updateDeal($user, 3);

        $course = $em->getRepository('WhatsdueMainBundle:Course')->find($data->assignment->course_id);
        $this->authorizeUser($this, $course->getAdminId());

        $assignment = new Assignment();
        $assignment->setAssignmentName($data->assignment->assignment_name);
        $assignment->setCourse($course);
        $assignment->setCourseId($data->assignment->course_id);
        $assignment->setDescription($data->assignment->description);
        $assignment->setAdminId($username);
        $assignment->setDueDate($data->assignment->due_date);
        $assignment->setTimeVisible($data->assignment->time_visible);
        $em->persist($assignment);
        //debug::dump($assignment);
        $em->flush();
        $assignment->setCourse(null);
        return array('assignment'=>$assignment);
    }

    /**
     * @return array
     * @View()
     */
    public function putAssignmentsAction($Id, Request $request){

        $data = json_decode($request->getContent());
        $em = $this->getDoctrine()->getManager();
        $assignment = $em->getRepository('WhatsdueMainBundle:Assignment')->find($Id);
        $assignment->setDueDate($data->assignment->due_date);
        $assignment->setDescription($data->assignment->description);
        $assignment->setAssignmentName($data->assignment->assignment_name);
        $assignment->setArchived($data->assignment->archived);
        $assignment->setTimeVisible($data->assignment->time_visible);

        /*Authorize*/
        $this->authorizeUser($this, $assignment->getAdminId());

        $em->flush();
        return array('assignment' => $assignment);
    }

    /**
     * @return array
     * @View()
     */
    public function deleteAssignmentsAction($Id){
        $em = $this->getDoctrine()->getManager();
        $assignment = $em->getRepository('WhatsdueMainBundle:Assignment')->find($Id);
        /*Authorize*/
        $this->authorizeUser($this, $assignment->getAdminId());

        $assignment->setArchived(true);
        $em->flush();

        return $this->view('', 204);
    }


    /**
     * @return array
     * @View()
     */
    public function getAssignmentAction($Id){

        $em = $this->getDoctrine()->getManager();
        $assignment = $em->getRepository('WhatsdueMainBundle:Assignment')->find($Id);
        /*Authorize*/
        if($this->currentUser($this)->getId() != $assignment->getCourse()->getUser()->getId()) exit;
        return array('assignment' => $assignment);
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
        $course = $_GET['course_id'];
        $repository = $this->getDoctrine()->getRepository('WhatsdueMainBundle:Message');
        $messages = $repository->findBy(array('courseId'=>$course));
        return array("message" => $messages);
    }

    /**
     * @return array
     * @View()
     */
    public function postMessagesAction( Request $request ){
        $data = json_decode($request->getContent());
        $message = new Messages();
        $message->setCourseId(  $data->message->course_id);
        $message->setTitle(     $data->message->title);
        $message->setBody(      $data->message->body);
        $em = $this->getDoctrine()->getManager();
        $em->persist($message);
        $em->flush();
        return array('message'=>$message);
    }

    /**
     * @return array
     * @View
     */

    public function postEmailInviteAction(Request $request){
        $data       = json_decode($request->getContent());
        $mailer     = $this->get('mailer');

        // Setting sender name as username:
        $user= $this->currentUser($this);
        $firstName  = $user->getFirstName();
        $lastName   = $user->getLastName();
        $salutation = $user->getSalutation();
        $from = array("aaron@whatsdueapp.com" => $firstName." ".$lastName);

        $message        = $data->email->message;
        $courseName     = $data->email->course_name;
        $courseCode     = $data->email->course_code;
        $subject        = "Please add $courseName on WhatsDue";

        // Fix formatting

        $messageHTML = str_replace("\n", "</p><p>", $message);

        /*
         * Handle Emails
         */
        $emailsRaw     = preg_split( "/\n|,| /", $data->email->email_list );
        $emailsDirty   = array_values( array_filter($emailsRaw) );
        $emailsValid   = [];
        $emailsInvalid     = [];
        foreach ($emailsDirty as $email){
            if (!filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
                // Email is valid
                $emailsValid[]=$email;
            } else{
                // Email is invalid
                $emailsInvalid[]=$email;
            }
        }

        /*
         * Prepare and Send Emails
         */

        $htmlBody = $this->renderView(
                 //app/Resources/views/email/invite.html.twig
                    'emails/invite.html.twig',
                    array(
                        'message'       => $messageHTML,
                        'courseName'    => $courseName,
                        'courseCode'    => $courseCode,
                        'teacherName'   => $salutation
                    )
                );
        $meta = array("courseName"=>$courseCode);
        $tag = "Invite Users";
        $this->get('email')->sendBulk($from, $user, $htmlBody, $message, $subject, $emailsValid, $tag, $meta);


        /* If its more than 5, update pipedrive */
        if (count($emailsValid) >= 5){
            $this->container->get('pipedrive')->updateDeal($user, 4);
        }
        return array(
            "emails_valid"      =>$emailsValid,
            "emails_invalid"    => $emailsInvalid
            );
    }

    /*
     * Settings
     */

    /**
     * @return array
     * @View()
     */
    public function getSettingsAction($settingName){
        $settingsSerialized = $this->currentUser($this)->getSettings();
        $settings = json_decode(stripslashes($settingsSerialized),true);
        if (@$setting = $settings[$settingName]){
            return $setting;
        }else{
            return "";
        }
    }

    /**
     * @return array
     * @View()
     */

    public function putSettingsAction($settingName, Request $request){
        $em = $this->getDoctrine()->getManager();
        $settingValue = $request->getContent();
        $user = $em->getRepository('WhatsdueMainBundle:User')->find($this->currentUser($this)->getId());
        $settingsSerialized = $user->getSettings();
        $settings = json_decode(stripslashes($settingsSerialized),true);
        $settings[$settingName] = $settingValue;
        var_dump($settings);
        $settingsSerialized = json_encode($settings);
        $user->setSettings($settingsSerialized);
        $em->flush();
        return $settings;
    }
}
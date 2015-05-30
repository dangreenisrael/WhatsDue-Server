<?php
/**
 * Created by PhpStorm.
 * User: dan
 * Date: 2014-04-14
 * Time: 11:59 AM
 */

namespace Whatsdue\MainBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\Common\Collections;
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


class TeacherController extends FOSRestController{


    private function currentUser($context){
        $username = @$context->container->get('request')->headers->get("key");
        $password = @$context->container->get('request')->headers->get("secret");
        return $this->container->get('helper')->loginUser($username, $password);
    }

    private function authorizeUser($context, $username_check){
        $username = @$context->container->get('request')->headers->get("key");
        $password = @$context->container->get('request')->headers->get("secret");
        $currentUser = $this->container->get('helper')->loginUser($username, $password);
        if ($currentUser->getUsername() != $username_check) exit;
        return true;
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
        $user = array(
            'id'                    => $user->getId(),
            'first_name'            => $user->getFirstName(),
            'last_name'             => $user->getLastName(),
            'email'                 => $user->getEmailCanonical(),
            'salutation'            => $user->getSalutation()
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

        $username = $this->currentUser($this)->getUsername();
        $repository = $this->getDoctrine()->getRepository('WhatsdueMainBundle:Courses');
        $courses = $repository->findByAdminId($username);
        $cleanCourses = [];
//        foreach($courses as $course){
//            $course->setDeviceIds(null);
//            $cleanCourses[] = $course;
//        }
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
        $course = new Courses();
        $course->setCourseName($data->course->course_name);
        $course->setInstructorName($data->course->instructor_name);
        $course->setAdminId($username);
        $course->setDeviceIds('{}');
        $course->setCourseCode($this->createCourseCode());
        $course->setSchoolName($school);
        $em = $this->getDoctrine()->getManager();
        $em->persist($course);
        $em->flush();
        /* Don't return device IDs*/
        $course->setDeviceIds(null);

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
        $course = $em->getRepository('WhatsdueMainBundle:Courses')->find($Id);
        /*Authorize*/
        $this->authorizeUser($this, $course->getAdminId());

        $course->setCourseName($data->course->course_name);
        $course->setInstructorName($data->course->instructor_name);
        $course->setArchived($data->course->archived);
        $em->flush();
        /* Don't return device IDs*/
        //$course->setDeviceIds(null);
        return array("course"=>$course);
    }

    /**
     * @return array
     * @View()
     */
    public function getCourseAction($courseId, Request $request){
        $em = $this->getDoctrine()->getManager();
        $course = $em->getRepository('WhatsdueMainBundle:Courses')->find($courseId);
        $course->setDeviceIds(null);
        /*Authorize*/
        $this->authorizeUser($this, $course->getAdminId());

        return $course;
    }

    /**
     * @return array
     * @View()
     */
    public function getCourseAssignmentsAction($courseId, Request $request){
        $em = $this->getDoctrine()->getManager();
        $assignments = $em->getRepository('WhatsdueMainBundle:Assignments')
            ->findBy(
                array('courseId' => $courseId)
            );

        /*Authorize*/
        $course = $em->getRepository('WhatsdueMainBundle:Courses')->find($courseId);
        $this->authorizeUser($this, $course->getAdminId());

        return $assignments;
    }


    /**
     * @return array
     * @View()
     */
    public function deleteCourseAction($Id){
        $em = $this->getDoctrine()->getManager();
        $course = $em->getRepository('WhatsdueMainBundle:Courses')->find($Id);
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
        $repository = $this->getDoctrine()->getRepository('WhatsdueMainBundle:Assignments');
        $assignments = $repository->findByAdminId($username);
        return array("assignment" => $assignments);
    }

    /**
     * @return array
     * @View()
     */
    public function postAssignmentsAction( Request $request ){
        $user = $this->currentUser($this);
        $username = $user->getUsername();

        $this->container->get('pipedrive')->updateDeal($user, 3);

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
        $assignment = $em->getRepository('WhatsdueMainBundle:Assignments')->find($Id);
        $assignment->setDueDate($data->assignment->due_date);
        $assignment->setDescription($data->assignment->description);
        $assignment->setAssignmentName($data->assignment->assignment_name);
        $assignment->setArchived($data->assignment->archived);
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
        $assignment = $em->getRepository('WhatsdueMainBundle:Assignments')->find($Id);
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
        $assignment = $em->getRepository('WhatsdueMainBundle:Assignments')->find($Id);
        /*Authorize*/
        $this->authorizeUser($this, $assignment->getAdminId());

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
        $repository = $this->getDoctrine()->getRepository('WhatsdueMainBundle:Messages');
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
    public function getSettingsAction($setting){
        $settingsSerialized = $this->currentUser($this)->getSettings();
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
        $user = $em->getRepository('WhatsdueMainBundle:User')->find($this->currentUser($this)->getId());
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
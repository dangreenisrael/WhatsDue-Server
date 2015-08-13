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
use Whatsdue\MainBundle\Entity\Message;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\FOSRestController;
use Whatsdue\MainBundle\Entity\StudentAssignment;

class TeacherController extends FOSRestController {

    public function createCourseCode(){
        return $courseCode = $this->container->get('helper')->createCourseCode();
    }

    /**
     * @return array
     * @View()
     */
    public function getUserAction(){
        $user = $this->getUser();

        $assignmentCount = 0;
        $students = [];
        foreach($user->getCourses() as $course){
            $assignmentCount += count($course->getAssignments());
            foreach($course->getStudents() as $student){
                $students[] = $student->getId();
            }
        }

        $students = array_unique($students);

        $user->uniqueStudents = count($students);
        $user->uniqueInvitations = 10;
        $user->totalCourses = count($user->getCourses());
        $user->totalAssignments = $assignmentCount;
        return array("user" => $user);
    }


    /*
     * Course Stuff
     */

    /**
     * @return array
     * @View()
     */
    public function getCoursesAction(){
        $courses = $this->getUser()->getCourses();
        return array("courses"=>$courses);
    }

    /**
     * @return array
     * @View()
     */
    public function postCourseAction(Request $request ){
        $user = $this->getUser();
        $data = json_decode($request->getContent());
        $course = new Course();
        $course->setCourseName($data->course->course_name);
        $salutation = $user->getSalutation();
        $firstName = $user->getFirstName();
        $lastName = $user->getLastName();
        $course->setInstructorName("$salutation $firstName $lastName");
        $course->setCourseCode($this->createCourseCode());
        $course->setUser($user);

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

        $course = $em->getRepository('WhatsdueMainBundle:Course')->find($Id);
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
        $students = [];
        foreach($course->getStudents() as $student){
            $students[] = $student->getId();
        }
        $course->studentList = array_values($students);

        return array(
            "course" => $course
        );
    }

//    /**
//     * @return array
//     * @View()
//     */
//    public function getCourseAssignmentsAction($courseId){
//
//        $em = $this->getDoctrine()->getManager();
//        $assignments = $em->getRepository('WhatsdueMainBundle:Assignment')
//            ->findBy(
//                array('courseId' => $courseId)
//            );
//        $course = $em->getRepository('WhatsdueMainBundle:Course')->find($courseId);
//        return array("assignment" => $assignments);
//    }


    /**
     * @return array
     * @View()
     */
    public function deleteCourseAction($Id){
        $em = $this->getDoctrine()->getManager();

        $course = $em->getRepository('WhatsdueMainBundle:Course')->find($Id);
        $course->setArchived(true);

        $em->flush();
        return $this->view('', 204);
    }


    /**
     * @return array
     * @View()
     */
    public function getStudentAction($studentId){
        $em = $this->getDoctrine()->getManager();
        $student = $em->getRepository('WhatsdueMainBundle:Student')->find($studentId);
        return array(
            "student" => $student
        );
    }


    /*
     * Assignments Stuff
     */

    /**
     * @return array
     * @View()
     */
    public function getAssignmentsAction(){

        $courses = $this->getUser()->getCourses();
        $courseIds = [];
        foreach ($courses as $course){
            $courseIds[] = $course->getId();
        }
        $em = $this->getDoctrine()->getManager();
        $assignments = $em->getRepository('WhatsdueMainBundle:Assignment')->findBy(array(
            'courseId' => $courseIds
        ));
        return array("assignment" => $assignments);
    }

    /**
     * @return array
     * @View()
     */
    public function postAssignmentsAction( Request $request ){
        $em = $this->getDoctrine()->getManager();
        $data = json_decode($request->getContent());
        $course = $em->getRepository("WhatsdueMainBundle:Course")->find($data->assignment->course_id);
        $assignment = new Assignment();
        $assignment->setAssignmentName($data->assignment->assignment_name);
        $assignment->setDescription($data->assignment->description);
        $assignment->setDueDate($data->assignment->due_date);
        $assignment->setTimeVisible($data->assignment->time_visible);
        $assignment->setCourseId($data->assignment->course_id);
        $assignment->setCourse($course);
        $em->persist($assignment);
        foreach($course->getStudents() as $student){
            $studentAssignment = new StudentAssignment();
            $studentAssignment->setStudent($student);
            $studentAssignment->setAssignment($assignment);
            $em->persist($studentAssignment);
        }
        $em->flush();
        $user = $this->getUser();
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
        return array('assignment' => $assignment);
    }








    /*
     * Messages Stuff
     */

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
        $message = new Message();
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
        $data       = json_decode($request->getContent())->email;
        $mailer     = $this->get('mailer');

        // Setting sender name as username:
        $user= $this->getUser();
        $firstName  = $user->getFirstName();
        $lastName   = $user->getLastName();
        $salutation = $user->getSalutation();
        $from = array("aaron@whatsdueapp.com" => $firstName." ".$lastName);

        $message        = $data->message;

        // Fix formatting

        $messageHTML = str_replace("\n", "</p><p>", $message);

        /*
         * Handle Emails
         */
        $emailsRaw     = preg_split( "/\n|,| /", $data->email_list );
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
        $courses = $this->getDoctrine()
            ->getRepository('WhatsdueMainBundle:Course')
            ->findBy(array(
                "id" => $data->courses
            ));

        foreach ($courses as $course){
            $subject = "Please add ".$course->getCourseName() ." on WhatsDue";
            $htmlBody = $this->renderView(
                'emails/invite.html.twig',
                array(
                    'message'       => $messageHTML,
                    'courseName'    => $course->getCourseName(),
                    'courseCode'    => $course->getCourseCode(),
                    'teacherName'   => $salutation
                )
            );
            $meta = array("courseCode"=>$course->getCourseCode());
            $tag = "Invite Users";
            $this->get('email')->sendBulk($from, $user, $htmlBody, $message, $subject, $emailsValid, $tag, $meta);
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
        $settingsSerialized = $this->getUser()->getSettings();
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
        $user = $em->getRepository('WhatsdueMainBundle:User')->find($this->getUser()->getId());
        $settingsSerialized = $user->getSettings();
        $settings = json_decode(stripslashes($settingsSerialized),true);
        $settings[$settingName] = $settingValue;
        $settingsSerialized = json_encode($settings);
        $user->setSettings($settingsSerialized);
        $em->flush();
        return $settings;
    }

    /**
     * @return array
     * @View()
     */

    public function getStatsAction(){
        $user = $this->getUser();
        $courses = $this->getUser()->getCourses();

        $studentList = [];
        $studentIds = [];

        /* Make a unique list of courses and students */
        foreach($courses as $course){
            if ($course->getArchived()){
                $courses->removeElement($course);
                continue;
            }
            foreach ($course->getStudents() as $student){
                $studentId = $student->getId();
                if (!in_array($studentId, $studentIds)){
                    $studentIds[] = $studentId;
                    $studentList[] = $student;
                }
            }
        }
        $stats = array(
            "id"            => 1,
            "course_count"  => count($courses),
            "student_count" => count($studentIds)
        );
        return array('stats'=> $stats);
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: dan
 * Date: 2014-04-14
 * Time: 11:59 AM
 */

namespace Whatsdue\MainBundle\Controller;


use FOS\RestBundle\Controller\FOSRestController;

use FOS\RestBundle\Controller\Annotations\View;
use Whatsdue\MainBundle\Entity\Device;
use Whatsdue\MainBundle\Entity\Student;
use Doctrine\Common\Util\Debug;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Whatsdue\MainBundle\Entity\StudentAssignment;


class OldStudentController extends FOSRestController{

    public function getHeader($header){
        $request = Request::createFromGlobals();
        return $request->headers->get($header);
    }

    public function getStudentId(){
//        if (@$_SESSION['studentId']) {
//            $studentId = $_SESSION['studentId'];
//        } elseif ( $this->getHeader('X-Student-Id') ){
//            $studentId = $this->getHeader('X-Student-Id');
//        } else{
//            $studentId = 0;
//        }
        $studentId = 1;
        return $studentId;
    }

    public function timestamp(){
        $date = new \DateTime();
        return $date->format('U')-4;
    }


    /**
     * @return array
     * @View()
     */
    public function getCourseAction($id){
        $course = $this->getDoctrine()->getRepository('WhatsdueMainBundle:Course')->find($id);
        return array("course"=>$course);
    }

    /**
     * @return array
     * @View()
     */
    public function getCoursesAction(){
        $student = $this->getDoctrine()
            ->getRepository('WhatsdueMainBundle:Student')->find($this->getStudentId());
        return array('course'=>$student->getCourses());

    }


    /******* Get Assignments by ID: json array of course IDs ********/


    public function filterAssignments($assignment){
        if ($this->getHeader('sendAll') == true){
            $timestamp = 0;
        } else{
            $timestamp = json_decode($this->getHeader('timestamp'));
        }
        return ($assignment->getLastModified() >= $timestamp);
    }
    /**
     * @return array
     * @View()
     */

    public function getAssignmentsAction(){
        $courses = json_decode($this->getHeader('courses'));
        $currentTime = $this->timestamp();
        $repo = $this->getDoctrine()->getRepository('WhatsdueMainBundle:Assignment');
        $assignments = $repo
            ->findBy( array(
                'courseId' => $courses
            ));
        $assignments = array_filter($assignments, array($this, 'filterAssignments'));
        $data = array(
            "assignment"=>$assignments,
            "meta"=>array(
                "timestamp"=> $currentTime
            )
        );
        return $data;
    }

    /**
     * @return array
     * @View()
     */
    public function getStudentAssignmentsAction(){
        $studentId = $this->getStudentId();
        $studentsAssignmentRepo = $this->getDoctrine()
            ->getRepository('WhatsdueMainBundle:StudentAssignment');
        $request = $this->get('request');
        $page = $request->query->get('page');
        $perPage = $request->query->get('per_page');
        if (!$page) $page = 1;
        if (!$perPage) $perPage = 21;
        return $studentsAssignmentRepo->findDuePaginated(
            $studentId,
            $page,
            $perPage
        );
    }

    /**
     * @return array
     * @View()
     */
    public function putStudentAssignmentsAction($assignmentId, Request $request){
        $data = json_decode($request->getContent())->assignment;
        var_dump($data);
        exit;
        $studentId = $this->getStudentId();
        $em = $this->getDoctrine()->getManager();
        $studentAssignment = $em->getRepository('WhatsdueMainBundle:StudentAssignment')
            ->findOneBy(array(
                "assignment"=>$assignmentId,
                "student"   =>$studentId
            ));
        $studentAssignment->setCompleted($data->completed);
        $studentAssignment->setCompletedDate($data->completed_date);
        $em->flush();
        return $studentAssignment;
    }

    /**
     * @return array
     * @View()
     */
    public function putAssignmentAction($assignmentId, Request $request){
        $data = json_decode($request->getContent())->assignment;
        $studentId = $this->getStudentId();
        $em = $this->getDoctrine()->getManager();
        $studentAssignment = $em->getRepository('WhatsdueMainBundle:StudentAssignment')
            ->findOneBy(array(
                "assignment"=>$assignmentId,
                "student"   =>$studentId
            ));
        $studentAssignment->setCompleted($data->completed);
        $studentAssignment->setCompletedDate($data->completed_date);
        $em->flush();
        return $studentAssignment;
    }

    /******* Get Messages by ID: json array of course IDs ********/

    public function filterMessages($message){
        if ($this->getHeader('sendAll') == true){
            $timestamp = 0;
        } else{
            $timestamp = json_decode($this->getHeader('timestamp'));
        }
        return ($message->getUpdatedAt() >= $timestamp);
    }
    /**
     * @return array
     * @View()
     */

    public function getMessagesAction(){
        $courses = json_decode($this->getHeader('courses'));
        $currentTime = $this->timestamp();
        $repo = $this->getDoctrine()->getRepository('WhatsdueMainBundle:Message');

        $messages = $repo
            ->findBy( array(
                'courseId' => $courses
            ));
        $messages = array_filter($messages, array($this, 'filterMessages'));

        $data = array(
            "message"=>$messages,
            "meta"=>array(
                "timestamp"=> $currentTime
            )
        );
        return $data;
    }

//    /**
//     * @return array
//     * @View()
//     */
//
//    public function postStudentAction(){
//        $uuid = $_POST['uuid'];
//        $platform = $_POST['platform'];
//        $pushId = $_POST['pushId'];
//        $em = $this->getDoctrine()->getManager();
//        if ($student = $em->getRepository('WhatsdueMainBundle:Device')->findOneBy(array('uuid' => $uuid))){
//            $student->setPushId($pushId);
//        } else{
//            $student = new Device;
//            $student->setUuid($uuid);
//            $student->setPlatform($platform);
//            $student->setPushId($pushId);
//            $em->persist($student);
//        }
//        $em->flush();
//        $_SESSION['studentId'] = $student->getId();
//        return array("primaryKey"=>$student->getId());
//    }


    /**
     * @return array
     * @View()
     */

    public function postStudentAction(){
        $uuid = $_POST['uuid'];
        $platform = $_POST['platform'];
        $pushId = $_POST['pushId'];
        $em = $this->getDoctrine()->getManager();
        $deviceRepo = $em->getRepository('WhatsdueMainBundle:Device');

        /* Check if device exists in records*/
        $deviceByPushId = $deviceRepo->findOneBy(array('pushId'=> $pushId));
        $deviceByUuid = $deviceRepo->findOneBy(array('uuid'=> $uuid));
        if (!$deviceByUuid && !$deviceByPushId){
            /* Create new Device and Student Record*/
            $student = new Student();
            $student->setFirstName("");
            $student->setLastName("");
            $student->setNotifications(true);
            $student->setNotifications(true);
            $student->setNotificationUpdates(true);
            $student->setNotificationTimeLocal("0000");
            $student->setNotificationTimeUtc("0000");
            $student->setOver12(false);
            $student->setSignupDate(date("Y-m-d"));
            $em->persist($student);

            $device = new Device();
            $device->setUuid($uuid);
            $device->setPlatform($platform);
            $device->setPushId($pushId);
            $device->setStudent($student);
            $em->persist($device);

            $em->flush();
        } else{
            /* Return existing Student record */
            if ($deviceByPushId){
                $device = $deviceByPushId;
                $device->setUuid($uuid);
            } else{
                $device = $deviceByUuid;
                $device->setPushId($pushId);
            }
            $student = $device->getStudent();
            $em->flush();
        }
        $_SESSION['studentId'] = $student->getId();
        return array("student"=>$student);
    }


    /**
     * @return array
     * @View()
     *
     * Depreciated August 2015
     */

    public function postCourseEnrollAction($courseId){
        $em = $this->getDoctrine()->getManager();
        $courseCode = $em->getRepository('WhatsdueMainBundle:Course')->find($courseId)->getCourseCode();
        $this->putCoursesEnrollAction($courseCode);
        return "Added Student";
    }

    /**
     * @return array
     * @View()
     *
     */

    public function putCoursesEnrollAction($courseCode){

        $em = $this->getDoctrine()->getManager();
        $studentRepo = $this->getDoctrine()->getRepository('WhatsdueMainBundle:Student');
        $student = $studentRepo->find($this->getStudentId());
        $course = $em
            ->getRepository('WhatsdueMainBundle:Course')
            ->findOneBy(array('courseCode'=> $courseCode));
        if($course){
            $salutation = $course->getUser()->getSalutation();
            $firstName = $course->getUser()->getFirstName();
            $lastName = $course->getUser()->getLastName();
            $course->setInstructorName("$salutation $firstName $lastName");
            if ($student){
                $course->addStudent($student);
                foreach($course->getAssignments() as $assignment){
                    $studentAssignment = new StudentAssignment();
                    $studentAssignment->setAssignment($assignment);
                    $studentAssignment->setStudent($student);
                    $em->persist($studentAssignment);
                }
                $em->flush();
            }
            return array("course"=> $course);
        }
        else{
            header("HTTP/1.1 404 Course Not Found");
            echo "Course not found";
            exit;
        }
    }


    /**
     * @return array
     * @View()
     *
     * Depreciated August 2015
     */

    public function postCourseUnenrollAction($courseId){
        $em = $this->getDoctrine()->getManager();
        $courseCode = $em->getRepository('WhatsdueMainBundle:Course')->find($courseId)->getCourseCode();
        $this->putCourseUnenrollAction($courseId);
        return "Removed Student";
    }

    /**
     * @return array
     * @View()
     */

    public function putCourseUnenrollAction($courseId){
        $em = $this->getDoctrine()->getManager();
        $student = $em->getRepository('WhatsdueMainBundle:Student')->find($this->getStudentId());
        $course = $em->getRepository('WhatsdueMainBundle:Course')->find($courseId);
        if ($student){
            $student->removeCourse($course);
            $course->removeStudent($student);
            $em->flush();
        }
        return array("course"=> $course);
    }



    /**
     * @return array
     * @View()
     *
     * Ember hack requires this $fillerId variable
     */

    public function putStudentsAction($fillerId, Request $request){
        $em = $this->getDoctrine()->getManager();
        $student = $em->getRepository('WhatsdueMainBundle:Student')->find($this->getStudentId());
        $data = json_decode($request->getContent())->student;
        $em = $this->getDoctrine()->getManager();
        $student->setNotifications($data->notifications);
        $student->setNotificationUpdates($data->notification_updates);
        $student->setNotificationTimeLocal($data->notification_time_local);
        $student->setNotificationTimeUtc($data->notification_time_utc);
        $student->setFirstName($data->first_name);
        $student->setLastName($data->last_name);
        $student->setOver12($data->over12);
        $student->setParentEmail($data->parent_email);
        $student->setRole($data->role);
        $student->setSignupDate($data->signup_date);
        $em->flush();
        return array("student"=> $student);
    }

    /**
     * @return array
     * @View()
     *
     * Note: As an ember hack we need to make student in an array
     */

    public function getStudentsAction(){
        $em = $this->getDoctrine()->getManager();
        $student = $em->getRepository('WhatsdueMainBundle:Student')->find($this->getStudentId());
        return array("student"=> array($student));
    }






    /**
     * @return array
     * @View()
     * Depreciated August 2015
     */
    public function getAllCoursesAction(){

        $data = array(
            "course"=>array(),
            "meta"=>array(
                "timestamp"=> 0
            )
        );
        return $data;
        $courses = $this->getDoctrine()->getRepository('WhatsdueMainBundle:Course');
        $sendAll = $this->getHeader('sendAll');
        $timestamp = json_decode($this->getHeader('timestamp'));
        if ($sendAll == true){
            //$courses = $courses->findAll();
        } else{
            $query = $courses->createQueryBuilder('p')
                ->where('p.lastModified >= :timestamp')
                ->setParameter('timestamp', $timestamp)
                ->getQuery();
            $courses = $query->getResult();
        }

        return null;
        $cleanCourses = [];
        foreach($courses as $course){
            $course->setDeviceIds(null);
            $cleanCourses[] = $course;
        }

        $data = array(
            "course"=>$cleanCourses,
            "meta"=>array(
                "timestamp"=> $this->timestamp()
            )
        );
        return $data;
    }
}
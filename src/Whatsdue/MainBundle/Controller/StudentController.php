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


class StudentController extends FOSRestController{

    public function __construct(){

        /*
         * Prevent unauthorized users
         */
      //  if($this->getHeader("X-Requested-With") != "com.whatsdue.app") exit;
    }

    public function getHeader($header){
        $request = Request::createFromGlobals();
        return $request->headers->get($header);
    }

    public function getStudent(){
        $studentRepo = $this->getDoctrine()->getRepository('WhatsdueMainBundle:Student');
        if (@$_SESSION['student']){
            $student = $_SESSION['student'];
        } elseif (@$_POST['primaryKey']){
            $student = $studentRepo->find($_POST['primaryKey']);
        } elseif ( $this->getHeader('X-Student-Id') ){
            $student = $studentRepo->find($this->getHeader('X-Student-Id'));
        } else{
            $student = $studentRepo->find(515);
        }
        $_SESSION['student'] = $student;
        return $student;
    }

    public function timestamp(){
        $date = new \DateTime();
        return $date->format('U')-4;
    }

    /******* Get a list of Courses ********/

    /**
     * @return array
     * @View()
     */
    public function getCourseAction($courseCode){
        $course = $this->getDoctrine()
                ->getRepository('WhatsdueMainBundle:Course')
                ->findOneBy(array('courseCode'=> $courseCode));
        if($course){
            $course->setDeviceIds(null);
            $data = array(
                "course"=>$course,
            );
            return $data;
        }
        else{
            header("HTTP/1.1 404 Course Not Found");
            echo "Course not found";
            exit;
        }
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

    public function putAssignmentCompleteAction($assignmentId){

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
            $student->setNotifications(true);
            $student->setNotificationUpdates(true);
            $student->setNotificationTimeLocal("0000");
            $student->setNotificationTimeUtc("0000");
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
            $em->flush();
        }
        return array("student"=>$this->getStudent());
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
        $course = $em
            ->getRepository('WhatsdueMainBundle:Course')
            ->findOneBy(array('courseCode'=> $courseCode));
        if($course){
            $course->addStudent($this->getStudent());
            $em->flush();
            return array(
                "course" => $course,
                "assignments"=> $course->getAssignments()
            );
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
        $student = $this->getStudent();
        $course = $em->getRepository('WhatsdueMainBundle:Course')->find($courseId);
        $student->removeCourse($course);
        $course->removeStudent($student);
        $em->flush();
        return array("student"=> $course);
    }



    /**
     * @return array
     * @View()
     */

    public function putStudentsAction($studentId, Request $request){
        $student = $this->getStudent();
        $data = json_decode($request->getContent())->student;
        $em = $this->getDoctrine()->getManager();
        $student->setNotifications($data->notifications);
        $student->setNotificationUpdates($data->notification_updates);
        $student->setNotificationTimeLocal($data->notification_time_local);
        $student->setNotificationTimeUtc($data->notification_time_utc);
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
        return array("student"=> array($this->getStudent()));
    }






    /**
     * @return array
     * @View()
     * Depreciated August 2015
     */
    public function getAllCoursesAction(){
        $courses = $this->getDoctrine()->getRepository('WhatsdueMainBundle:Course');
        $sendAll = $this->getHeader('sendAll');
        $timestamp = json_decode($this->getHeader('timestamp'));
        if ($sendAll == true){
            $courses = $courses->findAll();
        } else{
            $query = $courses->createQueryBuilder('p')
                ->where('p.lastModified >= :timestamp')
                ->setParameter('timestamp', $timestamp)
                ->getQuery();
            $courses = $query->getResult();
        }

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
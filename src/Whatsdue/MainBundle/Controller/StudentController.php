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
use Whatsdue\MainBundle\Entity\Device;
use Whatsdue\MainBundle\Entity\Consumer;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Whatsdue\MainBundle\Entity\ForumMessages;

header("Access-Control-Allow-Headers: courses, accept, content-type, timestamp, sendAll");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Origin: *");

class StudentController extends Controller{

    public function getHeader($header){
        $request = Request::createFromGlobals();
        return $request->headers->get($header);
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
    public function optionsAllCoursesAction(){
        return null;
    }

    /**
     * @return array
     * @View()
     */
    public function getAllCoursesAction(){
        $courses = $this->getDoctrine()->getRepository('WhatsdueMainBundle:Courses');
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

    /**
     * @return array
     * @View()
     */
    public function getCourseAction($courseCode){
        $course = $this->getDoctrine()
                ->getRepository('WhatsdueMainBundle:Courses')
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

    /**
     * @return array
     * @View()
     */
    public function optionsAssignmentsAction(){
        return null;
    }

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
        $repo = $this->getDoctrine()->getRepository('WhatsdueMainBundle:Assignments');

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


    /******* Get Messages by ID: json array of course IDs ********/

    /**
     * @return array
     * @View()
     */
    public function optionsMessagesAction(){
        return null;
    }

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
        $repo = $this->getDoctrine()->getRepository('WhatsdueMainBundle:Messages');

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

    /**
     * @return array
     * @View()
     */

    public function postStudentAction(){
        $uuid = $_POST['uuid'];
        $platform = $_POST['platform'];
        $pushId = $_POST['pushId'];
        $em = $this->getDoctrine()->getManager();
        if ($student = $em->getRepository('WhatsdueMainBundle:Device')->findOneBy(array('uuid' => $uuid))){
            $student->setPushId($pushId);
        } else{
            $student = new Device;
            $student->setUuid($uuid);
            $student->setPlatform($platform);
            $student->setPushId($pushId);
            $em->persist($student);
        }
        $em->flush();

        return array("primaryKey"=>$student->getId());
    }



    /**
     * @return array
     * @View()
     *
     * Depreciated August 2015
     */

    public function postCourseEnrollAction($courseId){
        $consumerId = $_POST['primaryKey'];
        $em = $this->getDoctrine()->getManager();
        $courseCode = $em->getRepository('WhatsdueMainBundle:Courses')->find($courseId)->getCourseCode();
        $this->putConsumersCoursesEnrollAction($consumerId, $courseCode);
        return "Added Student";
    }

    /**
     * @return array
     * @View()
     *
     * Depreciated August 2015
     */

    public function postCourseUnenrollAction($courseId){
        $consumerId = $_POST['primaryKey'];
        $em = $this->getDoctrine()->getManager();
        $courseCode = $em->getRepository('WhatsdueMainBundle:Courses')->find($courseId)->getCourseCode();
        $this->putConsumersCoursesUnenrollAction($consumerId, $courseCode);
        return "Removed Student";
    }

    /**
     * @return array
     * @View()
     */

    public function postConsumerAction(){
        $uuid = $_POST['uuid'];
        $platform = $_POST['platform'];
        $pushId = $_POST['pushId'];
        $em = $this->getDoctrine()->getManager();
        $deviceRepo = $em->getRepository('WhatsdueMainBundle:Device');

        /* Check if device exists in records*/
        $deviceByPushId = $deviceRepo->findOneBy(array('pushId'=> $pushId));
        $deviceByUuid = $deviceRepo->findOneBy(array('uuid'=> $uuid));

        if (!$deviceByUuid && !$deviceByPushId){
            /* Create new Device and Consumer Record*/
            $device = new Device();
            $device->setUuid($uuid);
            $device->setPlatform($platform);
            $device->setPushId($pushId);
            $em->persist($device);
            $em->flush();

            $consumer = new Consumer();
            $consumer->setDevices(json_encode($device->getId()));
            $consumer->setCourses('[]');
            $consumer->setNotifications(true);
            $consumer->setNotificationUpdates(true);
            $consumer->setNotificationTimeLocal("0000");
            $consumer->setNotificationTimeUtc("0000");

            $em->persist($consumer);
            $em->flush();
        } else{
            /* Return existing Consumer record */
            if ($deviceByPushId){
                $device = $deviceByPushId;
                $device->setUuid($uuid);
            } else{
                $device = $deviceByUuid;
                $device->setPushId($pushId);
            }
            $em->flush();
            $consumer = $em->getRepository('WhatsdueMainBundle:Consumer')->find($device->getConsumerId());
        }


        return array("consumer"=>$consumer);
    }



    /**
     * @return array
     * @View()
     *
     */

    public function putConsumersCoursesEnrollAction($consumerId, $courseCode){
        $em = $this->getDoctrine()->getManager();
        $course = $em
            ->getRepository('WhatsdueMainBundle:Courses')
            ->findOneBy(array('courseCode'=> $courseCode));
        if($course){
            $consumer = $em->getRepository('WhatsdueMainBundle:Consumer')->find($consumerId);
            $courseList = json_decode($consumer->getCourses(), true);
            $courseList[] = $course->getId();
            $courseList = array_unique($courseList);
            $consumer->setCourses(json_encode($courseList));

            $consumerList = json_decode($course->getConsumerIds(), true);
            $consumerList[] = intval($consumerId);
            $consumerList = array_unique($consumerList);
            $course->setConsumerIds(json_encode($consumerList));
            $em->flush();
//            $course->setDeviceIds(null);
//            $course->setConsumerIds(null);
            $data = array(
                "course"   => $course,
                "consumer" => $consumer
            );
            return $data;
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
     */
    public function optionsConsumerCoursesEnrollAction($consumerId, $courseId){
        return null;
    }

    /**
     * @return array
     * @View()
     */
    public function optionsConsumerCoursesUnenrollAction($consumerId, $courseId){
        return null;
    }

    /**
     * @return array
     * @View()
     */
    public function optionsConsumersAction($consumerId){
        return null;
    }


    /**
     * @return array
     * @View()
     */

    public function putConsumersCoursesUnenrollAction($consumerId, $courseId){
        $em = $this->getDoctrine()->getManager();
        $consumer = $em->getRepository('WhatsdueMainBundle:Consumer')->find($consumerId);
        $course = $em->getRepository('WhatsdueMainBundle:Courses')->find($courseId);

        /* Update Course */
        if ( $consumerList = json_decode($course->getConsumerIds(), true) ){
            /* Courses added with the new System */
            if (($key = array_search($consumerId, $consumerList)) !== false) {
                unset($consumerList[$key]);
            }
            $course->setConsumerIds(json_encode($consumerList));

            /* Update Consumer */
            $courseList = json_decode($consumer->getCourses(), true);
            if (($key = array_search($courseId, $courseList)) !== false) {
                unset($courseList[$key]);
            }
            $consumer->setCourses(json_encode($courseList));
        }

        $em->flush();
        return "Removed Student";
    }

    /**
     * @return array
     * @View()
     */

    public function putConsumersAction($consumerId, Request $request){
        $data = json_decode($request->getContent())->consumer;
        $em = $this->getDoctrine()->getManager();
        $consumer = $em->getRepository('WhatsdueMainBundle:Consumer')->find($consumerId);
        $consumer->setNotifications($data->notifications);
        $consumer->setNotificationUpdates($data->notification_updates);
        $consumer->setNotificationTimeLocal($data->notification_time_local);
        $consumer->setNotificationTimeUtc($data->notification_time_utc);
        $em->flush();
        return array("consumer"=> $consumer);
    }

    /**
     * @return array
     * @View()
     */

    public function getConsumersAction($consumerId){
        $em = $this->getDoctrine()->getManager();
        $consumer = $em->getRepository('WhatsdueMainBundle:Consumer')->find($consumerId);
        return array("consumer"=> $consumer);
    }
}


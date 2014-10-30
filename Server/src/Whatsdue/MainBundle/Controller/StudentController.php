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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;

header("Access-Control-Allow-Headers: courses, accept, content-type, timestamp, sendAll");
header("Access-Control-Allow-Method: GET, POST, OPTION");
header("Access-Control-Allow-Origin: *");

class StudentController extends Controller{

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
        $sendAll = $this->getHeader('sendAll');
        $timestamp = json_decode($this->getHeader('timestamp'));
        if ($sendAll == true){
            $products = $courses->findAll();
        } else{
            $query = $courses->createQueryBuilder('p')
                ->where('p.lastModified >= :timestamp')
                ->setParameter('timestamp', $timestamp)
                ->getQuery();
            $products = $query->getResult();
        }

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

    /**
     * @return array
     * @View()
     */

    public function postStudentAction(){
        $uuid = $_POST['uuid'];
        $platform = $_POST['platform'];
        $pushId = $_POST['pushId'];
        $em = $this->getDoctrine()->getManager();
        if ($student = $em->getRepository('WhatsdueMainBundle:Students')->findOneBy(array('uuid' => $uuid))){
            $student->setPushId($pushId);
        } else{
            $student = new Students;
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
     */

    public function postCourseEnrollAction($courseId){
        $primaryKey = $_POST['primaryKey'];
        if ($primaryKey == "") return "No UUID";
        $em = $this->getDoctrine()->getManager();
        $student = $em->getRepository('WhatsdueMainBundle:Students')->find($primaryKey);
        $course = $em->getRepository('WhatsdueMainBundle:Courses')->find($courseId);
        $uuid = $student->getUuid();

        $subscribers   = $course->getDeviceIds();
        $subscribers   = json_decode($subscribers, true);
        if (@!in_array($uuid, $subscribers)) $subscribers[] = $uuid;
        $course ->setDeviceIds(json_encode($subscribers));

        $em->flush();
        return "Added Student";
    }

    /**
     * @return array
     * @View()
     */

    public function postCourseUnenrollAction($courseId){

        $primaryKey = $_POST['primaryKey'];
        if ($primaryKey =="") return "No Push";
        $em = $this->getDoctrine()->getManager();
        $student = $em->getRepository('WhatsdueMainBundle:Students')->find($primaryKey);
        $course = $em->getRepository('WhatsdueMainBundle:Courses')->find($courseId);
        $uuid = $student->getUuid();


        $subscribers   = $course->getDeviceIds();
        $subscribers   = json_decode($subscribers, true);

        if(($key = array_search($uuid, $subscribers)) !== false) {
            unset($subscribers[$key]);
        }
        $course ->setDeviceIds(json_encode($subscribers));
        $em->flush();
        return "Removed Student";
    }
}
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


class StudentController extends FOSRestController{

    public function getHeader($header){
        $request = Request::createFromGlobals();
        return $request->headers->get($header);
    }

    public function timestamp(){
        $date = new \DateTime();
        return $date->format('U')-4;
    }


    /**** Student Stuff ****/

    public function getStudent(){
        $em = $this->getDoctrine()->getManager();
        $studentRepo = $em->getRepository('WhatsdueMainBundle:Student');
        $deviceRepo = $em->getRepository('WhatsdueMainBundle:Device');
        if ( $this->getHeader('X-Student-Id') ){
            $student = $studentRepo->find($this->getHeader('X-Student-Id'));
        } elseif ( $this->getHeader('X-UUID') ){
            $student = $deviceRepo->findOneBy(array('uuid'=> $this->getHeader('X-UUID')))->getStudent();
        } else{
            $student = $studentRepo->find(0);
        }
        return $student;
    }

    public function getStudentId(){
        return $this->getStudent()->getId();
    }

    /**
     * @return array
     * @View()
     *
     * Note: As an ember hack we need to put student in an array
     */

    public function getStudentsAction(){
        $student = $this->getStudent();
        return array("student"=> array($student));
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
        return array("student"=>$student);
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

    /**** COURSES ****/

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
        $student = $this->getStudent();
        return array('course'=>$student->getCourses());

    }

    /**
     * @return array
     * @View()
     *
     */
    public function postCoursesAction(Request $request){
        $courseCode = json_decode($request->getContent())->course->course_code;
        $em = $this->getDoctrine()->getManager();
        $studentRepo = $this->getDoctrine()->getRepository('WhatsdueMainBundle:Student');
        $student = $studentRepo->find($this->getStudentId());
        $courseRepo = $em
            ->getRepository('WhatsdueMainBundle:Course');
        $course = $courseRepo->findOneBy(array('courseCode'=> $courseCode));
        if($course){

            if ($courseRepo->hasStudent($course, $student)){
                return array("course"=>
                    array("error"=>"You are already enrolled in this class")
                );
            }
            $salutation = $course->getUser()->getSalutation();
            $firstName = $course->getUser()->getFirstName();
            $lastName = $course->getUser()->getLastName();
            $course->setInstructorName("$salutation $firstName $lastName");
            if ($student){
                $course->addStudent($student);
                $i=0;
                foreach($course->getAssignments() as $assignment){
                    $i++;
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
            return array("course"=>
                array("error"=>"Invalid Course Code")
            );
        }
    }

    /**
     * @return array
     * @View()
     */

    public function deleteCourseAction($courseId){
        $em = $this->getDoctrine()->getManager();
        $studentId = $this->getStudentId();
        $student = $em->getRepository('WhatsdueMainBundle:Student')->find($studentId);
        $course = $em->getRepository('WhatsdueMainBundle:Course')->find($courseId);
        $studentAssignments = $em->getRepository('WhatsdueMainBundle:StudentAssignment')->findStudentCourse($studentId, $courseId);
        if ($student){
            $student->removeCourse($course);
            $course->removeStudent($student);
            foreach($studentAssignments as $studentAssignment){
                $em->remove($studentAssignment);
            }
            $em->flush();
        }
        return null;
    }


    /**** Assignments ****/

    /**
     * @return array
     * @View()
     */
    public function getAssignmentsAction(Request $request){
        $studentId = $this->getStudentId();
        $studentsAssignmentRepo = $this->getDoctrine()
            ->getRepository('WhatsdueMainBundle:StudentAssignment');
        $page = $request->query->get('page');
        $perPage = $request->query->get('per_page');
        $completed = $request->query->get('completed');
        if (!$page) $page = 1;
        if (!$perPage) $perPage = 21;
        if ($completed){
            return $studentsAssignmentRepo->findCompleted($studentId);
        } else{
            return $studentsAssignmentRepo->findPaginated(
                $studentId,
                $page,
                $perPage
            );
        }
    }

    /**
     * @return array
     * @View()
     */

    public function getUpdatesAssignmentsAction($timestamp){
        $repo = $this->getDoctrine()->getRepository('WhatsdueMainBundle:StudentAssignment');
        return $repo->findAssignmentTimestamp($this->getStudentId(), $timestamp);
    }

    /**
     * @return array
     * @View()
     */
    public function putAssignmentsAction($assignmentId, Request $request){
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
        $assignment = $studentAssignment->getAssignment();
        $assignment->setCompleted($data->completed);
        $assignment->setCompletedDate($data->completed_date);
        return array("assignment" => $assignment);
    }

    /**
     * @return array
     * @View()
     */
    public function getTestConnectionAction(){
        return true;
    }
}
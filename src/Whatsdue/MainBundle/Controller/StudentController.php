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
use Whatsdue\MainBundle\Entity\Assignment;
use Whatsdue\MainBundle\Entity\Course;
use Whatsdue\MainBundle\Entity\CourseRepository;
use Whatsdue\MainBundle\Entity\StudentAssignmentRepository;

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
            $userById = $deviceRepo->findOneBy(array('uuid'=> $this->getHeader('X-UUID')));
            if ($userById){
                $student = $userById->getStudent();
            } else{
                $student = $studentRepo->find(0);
            }
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
        var_dump($_POST);
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
        }
        $student->setLastIp($_SERVER['REMOTE_ADDR']);
        $em->flush();
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
        /**@var Student $student */
        $student = $studentRepo->find($this->getStudentId());
        /**@var CourseRepository $courseRepo */
        $courseRepo = $em
            ->getRepository('WhatsdueMainBundle:Course');
        /**@var Course $course **/
        $course = $courseRepo->findOneBy(array('courseCode'=> $courseCode));
        if($course){
            if ($courseRepo->hasStudent($course, $student)){
                return array("course"=>
                    array("error"=>"You just tried joining "
                        .$course->getCourseName().
                        " but you are already in that class")
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
        /**@var StudentAssignmentRepository $studentAssignmentsRepo */
        $studentAssignmentsRepo = $em->getRepository('WhatsdueMainBundle:StudentAssignment');
        $studentAssignments = $studentAssignmentsRepo->findStudentCourse($studentId, $courseId);
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
        /**@var StudentAssignmentRepository $studentAssignmentRepo */
        $studentAssignmentRepo = $this->getDoctrine()
            ->getRepository('WhatsdueMainBundle:StudentAssignment');
        $page = $request->query->get('page');
        $perPage = $request->query->get('per_page');
        $completed = $request->query->get('completed');
        if (!$page) $page = 1;
        if (!$perPage) $perPage = 21;
        if ($completed){
            return $studentAssignmentRepo->findCompleted($studentId);
        } else{
            return $studentAssignmentRepo->findPaginated(
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
        /**@var StudentAssignmentRepository $studentAssignmentsRepo */
        $studentAssignmentsRepo = $this->getDoctrine()->getRepository('WhatsdueMainBundle:StudentAssignment');
        return $studentAssignmentsRepo->findAssignmentTimestamp($this->getStudentId(), $timestamp);
    }

    /**
     * @return array
     * @View()
     */
    public function putAssignmentsAction($assignmentId, Request $request){
        $data = json_decode($request->getContent())->assignment;
        $timeCompleted = $data->completed_date;
        /* For HHVM compatibility we need to make the millisecond timestamp to seconds */
        /* This 'if' can be removed in March 2016 */
        if (!preg_match('/^\d{10}$/', $timeCompleted)) {
            $timeCompleted = round($timeCompleted*0.001);
        }
        $studentId = $this->getStudentId();
        $em = $this->getDoctrine()->getManager();
        $studentAssignment = $em->getRepository('WhatsdueMainBundle:StudentAssignment')
            ->findOneBy(array(
                "assignment"=>$assignmentId,
                "student"   =>$studentId
            ));
        $studentAssignment->setCompleted($data->completed);
        $studentAssignment->setCompletedDate($timeCompleted);
        /** @var Assignment $assignment **/
        $assignment = $studentAssignment->getAssignment();
        $assignment->setCompleted($data->completed);
        $assignment->setCompletedDate($timeCompleted);
        if (!empty($data->seen)){
            $timeSeen = $data->seen_date;
            $studentAssignment->setSeen($timeSeen);
            $studentAssignment->setSeenDate($timeSeen);
            $assignment->setSeenDate($timeSeen);
            $assignment->setSeen($data->seen);
        }
        $em->flush();
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
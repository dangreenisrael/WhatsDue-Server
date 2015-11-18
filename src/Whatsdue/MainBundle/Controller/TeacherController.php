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
use Unirest;
use Doctrine\Common\Collections\Criteria;

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
        return array("user" => $user);
    }

    private function getAssignment($id){
        $em = $this->getDoctrine()->getManager();
        $assignment = $em->getRepository('WhatsdueMainBundle:Assignment')->find($id);
        if ($assignment->getCourse()->getUser()->getId() != $this->getUser()->getId()) exit;
        return $assignment;
    }

    private function getCourse($id){
        $em = $this->getDoctrine()->getManager();
        $course = $em->getRepository('WhatsdueMainBundle:Course')->find($id);
        $studentIds = [];
        foreach($course->getStudents() as $student){
            $studentIds[] = $student->getId();
        }
        $course->studentList = array_values($studentIds);
        if ($course->getUser()->getId() != $this->getUser()->getId()) exit;
        return $course;
    }

    private function getStatus($id){
        $em = $this->getDoctrine()->getManager();
        $status = $em->getRepository('WhatsdueMainBundle:StudentAssignment')->find($id);
        //if ($status->getAssignment()->getUser()->getId() != $this->getUser()->getId()) exit;
        return $status;
    }

    /*
     * Course Stuff
     */

    /**
     * @return array
     * @View()
     */
    public function getCoursesAction(){
        $criteria = Criteria::create()->where(Criteria::expr()->neq("archived", true));
        $courses = $this->getUser()->getCourses()->matching($criteria);
        $courses = call_user_func_array('array_merge', (array)$courses);
        return array("courses"=> $courses);
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
    public function putCourseAction($id, Request $request){
        $data = json_decode($request->getContent());
        $em = $this->getDoctrine()->getManager();
        $course = $this->getCourse($id);
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
    public function getCourseAction($id){
        $em = $this->getDoctrine()->getManager();
        $course = $this->getCourse($id);
        return array(
            "course" => $course
        );
    }


    /**
     * @return array
     * @View()
     */
    public function deleteCourseAction($id){
        $em = $this->getDoctrine()->getManager();

        $course = $this->getCourse($id);
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
        $criteria = Criteria::create()->where(Criteria::expr()->neq("archived", true));
        $courses = $this->getUser()->getCourses()->matching($criteria);
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
    public function postAssignmentsBulkAction( Request $request ){
        $em = $this->getDoctrine()->getManager();
        $courses = json_decode($request->getContent());
        $bulkId = rand(0,999999999999999);
        foreach ($courses as $course){
            $currentCourse = $em->getRepository("WhatsdueMainBundle:Course")->find($course->id);
            foreach($course->assignment as $assignment){
                $newAssignment = new Assignment();
                $newAssignment->setAssignmentName($assignment->assignment_name);
                $newAssignment->setDescription($assignment->description);
                $newAssignment->setDueDate($assignment->due_date);
                $newAssignment->setTimeVisible($assignment->time_visible);
                $newAssignment->setCourseId($course->id);
                $newAssignment->setCourse($currentCourse);
                $newAssignment->setBulkId($bulkId);
                $newAssignment->setIsBulk(true);
                $em->persist($newAssignment);
                foreach($currentCourse->getStudents() as $student){
                    $studentAssignment = new StudentAssignment();
                    $studentAssignment->setStudent($student);
                    $studentAssignment->setAssignment($newAssignment);
                    $em->persist($studentAssignment);
                }
            }
        }
        $em->flush();
        return array('Multiple Assignments Added');
    }

    /**
     * @return array
     * @View()
     */
    public function putAssignmentsAction($id, Request $request){

        $data = json_decode($request->getContent());
        $em = $this->getDoctrine()->getManager();
        $assignment = $this->getAssignment($id);
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
    public function deleteAssignmentAction($id){
        $em = $this->getDoctrine()->getManager();
        $assignment = $this->getAssignment($id);
        $assignment->setArchived(true);
        $em->flush();
        return $this->view('', 204);
    }

    /**
     * @return array
     * @View()
     */
    public function getAssignmentAction($id){
        $em = $this->getDoctrine()->getManager();
        $assignment = $this->getAssignment($id);
        return array('assignment' => $assignment);
    }

    /**
     * @return array
     * @View()
     */

    public function getStatusAction($id){
        $status = $this->getStatus($id);
        //debug::dump($this->getAssignment($id)->getStudentAssignments());
        //exit;
        return array('status' => $status);
    }

    /**
     * @return array
     * @View()
     */

    public function getStatusesAction(Request $request){
        $assignmentId = $request->query->get('assignment', null);
        $studentId    = $request->query->get('student', null);
        $courseId     = $request->query->get('course', null);
        $em = $this->getDoctrine()->getManager();
        $studentAssignmentRepo = $em->getRepository('WhatsdueMainBundle:StudentAssignment');
        if (!$courseId){
            $findParams = array();
            if ($assignmentId)    $findParams['assignment'] = $assignmentId;
            if ($studentId)       $findParams['student']    = $studentId;
            $statuses = $studentAssignmentRepo->findBy($findParams);
        } else{
            $courseRepo = $em->getRepository('WhatsdueMainBundle:Course');
            $statuses = $courseRepo->studentAssignments($courseId);
        }


        return array("status" => $statuses);
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
        if (@$data->message){
            $message = $data->message;
        } else{
            $message = "";
        }
        return $this->get('email')->sendInvites(
            $this->getUser(),
            $message,
            $data->courses,
            $data->email_list
        );
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: dan
 * Date: 2014-12-01
 * Time: 11:29 AM
 */

namespace Whatsdue\MainBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\Controller\FOSRestController;
use Whatsdue\MainBundle\Entity\Messages;
use Whatsdue\MainBundle\Entity\School;
use Moment\Moment;
use Whatsdue\MainBundle\Classes\PushNotifications;


class AdminController extends FOSRestController{

    public function getHeader($header){
        $request = Request::createFromGlobals();
        return $request->headers->get($header);
    }


    /**
     * @return array
     * @View()
     */
    public function getGenerateCodesAction(){
        $em = $this->getDoctrine()->getManager();
        $records = $em
            ->getRepository('WhatsdueMainBundle:Courses')
            ->findBy(array("courseCode"=>null));

        foreach ($records as $record){
            $courseCode = $this->container->get('helper')->createCourseCode();
            $record->setCourseCode($courseCode);
        }
        $em->flush();

        return $records;
    }


    /**
     * @return array
     * @View()
     */
    public function getUsersAction(){
        $userRepository = $this->getDoctrine()->getRepository('WhatsdueMainBundle:User');
        $assignmentRepository = $this->getDoctrine()->getRepository('WhatsdueMainBundle:Assignments');
        $courseRepository = $this->getDoctrine()->getRepository('WhatsdueMainBundle:Courses');

        $users = $userRepository->findAll();

        $i = 0;
        foreach ($users as $user){
            $i++;
            $courses = $courseRepository->findBy(
                array('adminId'  => $user->getUsername(), 'archived' => 0)
            );
            /* Total Unique Users */
            $deviceIds = [];
            foreach ($courses as $course){
                $currentDeviceIds = json_decode($course->getDeviceIds(), true);
                $deviceIds = @array_merge($deviceIds, $currentDeviceIds);
            }
            $uniqueUsers = @array_unique($deviceIds);
            $assignments = $assignmentRepository->findBy(
                array('adminId'  => $user->getUsername())
            );

            $teachers[$i] = array(
                'id'                => $user->getId(),
                'username'          => $user->getUsername(),
                'email'             => $user->getEmailCanonical(),
                'last_login'        => $user->getLastLogin(),
                'course_count'      => count($courses),
                'assignment_count'  => count($assignments),
                'unique_users'      => count($uniqueUsers)
            );
        }

        return array("users" => array_values($teachers));
    }

//    /**
//     * @return array
//     * @View()
//     */
//    public function getUserAction($id){
//        $userRepository = $this->getDoctrine()->getRepository('WhatsdueMainBundle:User');
//        $assignmentRepository = $this->getDoctrine()->getRepository('WhatsdueMainBundle:Assignments');
//        $courseRepository = $this->getDoctrine()->getRepository('WhatsdueMainBundle:Courses');
//
//        $user = $userRepository->find($id);
//
//        $courses = $courseRepository->findBy(
//            array('adminId'  => $user->getUsername(), 'archived' => 0)
//        );
//
//        /* Total Unique Users */
//        $deviceIds = [];
//        foreach ($courses as $course){
//            $currentDeviceIds = json_decode($course->getDeviceIds(), true);
//            $deviceIds = array_merge($deviceIds, $currentDeviceIds);
//        }
//        $uniqueUsers = array_unique($deviceIds);
//        $assignments = $assignmentRepository->findBy(
//            array('adminId'  => $user->getUsername())
//        );
//
//        $user = array(
//            'id'                => $user->getId(),
//            'username'          => $user->getUsername(),
//            'email'             => $user->getEmailCanonical(),
//            'last_login'        => $user->getLastLogin(),
//            'course_count'      => count($courses),
//            'assignment_count'  => count($assignments),
//            'unique_users'      => count($uniqueUsers)
//        );
//
//        return array("users" => $user);
//    }

    /**
     * @return array
     * @View()
     */
    public function getSchoolsAction(){

        $schoolRepository = $this->getDoctrine()->getRepository('WhatsdueMainBundle:School');
        $schools = $schoolRepository->findAll();
        $i = 0;

        foreach ($schools as $school){
            $i++;
            $stats = $this->schoolStats($school);
            $school->setTotalCourses($stats['courses']);
            $school->setTotalUsers($stats['users']);
            $SchoolInfo[$i] = $school;
        }

        return array("school" => array_values($SchoolInfo));
    }


    /**
     * @return array
     * @View()
     */
    public function postSchoolAction(Request $request ){
        $data = json_decode($request->getContent());
        $school = new School();
        $school->setName($data->school->name);
        $school->setCity($data->school->city);
        $school->setRegion($data->school->region);
        $school->setCountry($data->school->country);
        $school->setAddress($data->school->address);
        $school->setContactName($data->school->contact_name);
        $school->setContactEmail($data->school->contact_email);
        $school->setContactPhone($data->school->contact_phone);
        $school->setArchived(false);
        $school->setTotalCourses(0);
        $school->setTotalUsers(0);
        $em = $this->getDoctrine($data->school->name)->getManager();
        $em->persist($school);
        $em->flush();
        return array("school" => $school);
    }

    /**
     * @return array
     * @View()
     */
    public function putSchoolAction($schoolId, Request $request){
        $data = json_decode($request->getContent());
        $em = $this->getDoctrine()->getManager();
        $school = $em->getRepository('WhatsdueMainBundle:School')->find($schoolId);
        $school->setCity($data->school->city);
        $school->setRegion($data->school->region);
        $school->setCountry($data->school->country);
        $school->setAddress($data->school->address);
        $school->setContactName($data->school->contact_name);
        $school->setContactEmail($data->school->contact_email);
        $school->setContactPhone($data->school->contact_phone);

        $stats = $this->schoolStats($school);
        $school->setTotalCourses($stats['courses']);
        $school->setTotalUsers($stats['users']);

        $em->flush();

        return array("school"=>$school);
    }

    /**
     * @return array
     * @View()
     */
    public function getSchoolsListAction(){
        $schoolRepository = $this->getDoctrine()->getRepository('WhatsdueMainBundle:School');
        $school = $schoolRepository->findAll();
        return array("school" => $school);
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
     * Send message to ALL users
     */
    public function postMessageAction( Request $request ){
        $username = $this->getUser()->getUsername();
        $data = json_decode($request->getContent());
        $title = $data->message->title;
        $body = $data->message->body;
        $message = new Messages();
        $message->setCourseId(0);
        $message->setTitle($title);
        $message->setBody($body);
        $message->setUsername($username);
        $em = $this->getDoctrine()->getManager();
        $em->persist($message);
        $em->flush();

        $studentRepository = $this->getDoctrine()->getRepository('WhatsdueMainBundle:Students');
        $allStudents = $studentRepository->findAll();
        $allUuids = array();
        foreach ($allStudents as $student){
            $allUuids[] = $student->getUuid();
        }

        $pushNotifications = $mailer = $this->get('push_notifications');
        $pushNotifications->sendNotifications($title, $body, $allUuids);
        //$pushNotifications->sendNotifications($title, $body, array('39cd2c28c433efca'));

        return array('message'=>$message);
    }


    /**
     * @return array
     * @View()
     * Get list of logged emails
     */

    public function getEmailsAction(){
        $emailRepository = $this->getDoctrine()->getRepository('WhatsdueMainBundle:EmailLog');
        $emails = $emailRepository->findAll();
        return array('email'=>$emails);
    }

    /**
     * @return array
     * @View()
     * Get All the stats for Aaron
     *
     * * Total Teacher Signups
     * * Total Teachers with min 5 users
     * * Total schools with multiple teachers signed up
     *
     * * Starting from first blog post - user 144
     */
    public function getStatsAction(){
        define ("firstUser", 0);
        $minUsers = $_GET["minUsers"];
        $loggedInWeeksAgo = $_GET["loggedInWeeksAgo"];
        $moment = new Moment();
        $moment->subtractWeeks($loggedInWeeksAgo);
        $afterDate = $moment->format('Y-m-d H:i:s');

        $doctrine = $this->getDoctrine();
        $teachersRepo = $doctrine->getRepository('WhatsdueMainBundle:User');

        /* Get all teachers with min users */
        $query = $teachersRepo->createQueryBuilder('teacher')
            ->where('teacher.id >= :firstUser')
            ->andWhere('teacher.uniqueFollowers >= :minUsers')
            ->andWhere('teacher.lastLogin >= :afterDate')
            ->setParameter('firstUser', firstUser)
            ->setParameter('minUsers', $minUsers)
            ->setParameter('afterDate', $afterDate)
            ->getQuery();
        $allTeachers = $query->getResult();

        /* Array of user counts (for averages */
        $userCounts = [];
        foreach($allTeachers as $teacher){
            $userCounts[] = $teacher->getUniqueFollowers();
        };




        return array("stats" => array(
            "total" => count($allTeachers),
            "median users" => $this->calculate_median($userCounts),
            "mean users" => $this->calculate_average($userCounts)
        ));

    }

    /* Helper Methods */
    private function schoolStats($school){
        $courseRepository = $this->getDoctrine()->getRepository('WhatsdueMainBundle:Courses');
        $courses = $courseRepository->findBy(
            array('schoolName'  => $school->getName(), 'archived' => 0)
        );
        /* Total Unique Users */
        $deviceIds = [];
        foreach ($courses as $course){
            $currentDeviceIds = json_decode($course->getDeviceIds(), true);
            $deviceIds = @array_merge($deviceIds, $currentDeviceIds);
        }

        $count['courses'] = count($courses);
        $count['users']   = count(@array_unique($deviceIds));
        return $count;
    }

    private function calculate_median($arr) {
        sort($arr);
        $count = count($arr); //total numbers in array
        $middleval = floor(($count-1)/2); // find the middle value, or the lowest middle value
        if($count % 2) { // odd number, middle is the median
            $median = $arr[$middleval];
        } else { // even number, calculate avg of 2 medians
            $low = $arr[$middleval];
            $high = $arr[$middleval+1];
            $median = (($low+$high)/2);
        }
        return $median;
    }

    private function calculate_average($arr) {
        $count = count($arr); //total numbers in array
        $total = 0;
        foreach ($arr as $value) {
            $total = $total + $value; // total value of array numbers
        }
        $average = ($total/$count); // get average value
        return $average;
    }

}

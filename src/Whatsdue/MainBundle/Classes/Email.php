<?php
/**
 * Created by PhpStorm.
 * User: Dan
 * Date: 4/14/15
 * Time: 15:03
 */

namespace Whatsdue\MainBundle\Classes;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Whatsdue\MainBundle\Entity\EmailLog;
use Unirest\Request;
use Kickbox;
use Mailgun\Mailgun;


class Email {
    protected $container;

    public function __construct(ContainerInterface $container){
        $this->container = $container;
    }

    public function validate($emailAddress){
        $client   = new Kickbox\Client('4ef4e6beed7b8dd0e53084610169d7e626ca4bd0e5237bb561676b7cb8351a7d');
        $kickbox  = $client->kickbox();

        try {
            $response = $kickbox->verify($emailAddress);
            $response = $response->body;
            if ($response['result'] == "valid"
                || $response['result'] == "deliverable"
                || $response['accept_all'] == true){
                return array(
                    "valid" => true
                );
            } else{
                return array(
                    "valid" => false
                );
            }
        }
        catch (Exception $e) {
            return array(
                "valid" => true
            );
        }
    }

    public function sendBulk($from, $user, $htmlBody, $txtBody, $subject, $recipients, $tag, $meta){
        $mailer = $this->container->get('mailer');
        $mg = new Mailgun("key-3997afe1674cb12b3bcecb21c993147a");
        $domain = "whatsdueapp.com";

        /* Send Email */
        foreach($recipients as $recipient){
            $mg->sendMessage($domain, array(
                    'from'    => $from,
                    'to'      => $recipient,
                    'subject' => $subject,
                    'html'    => $htmlBody
                )
            );
        }


        /* Log Email */

        $emailLog = new EmailLog();
        $emailLog->setSubject($subject);
        $emailLog->setBody($txtBody);
        $emailLog->setRecipients(json_encode($recipients));
        $emailLog->setRecipientCount(count($recipients));
        $emailLog->setTag($tag);
        $emailLog->setUser($user);
        $emailLog->setMeta(json_encode($meta));

        $emailLog->setDate($this->container->get('helper')->getUserDateTime());
        $em = $this->container->get('doctrine')->getManager();
        $em->persist($emailLog);
        $em->flush();
    }

    public function sendInvites($user, $messageTxt, $courseIds, $emailList){
        $messageHTML = str_replace("\n", "</p><p>", $messageTxt);
        // Setting sender name as username:
        $firstName  = $user->getFirstName();
        $lastName   = $user->getLastName();
        $salutation = $user->getSalutation();
        $from = array($firstName." ".$lastName . "<aaron@whatsdueapp.com>");

        /*
         * Prepare and Send Emails
         */
        $courses = $this->container->get('doctrine')
            ->getRepository('WhatsdueMainBundle:Course')
            ->findBy(array(
                "id" => $courseIds
            ));
        foreach ($courses as $course){
            $branchLink = Request::post(
                $this->container->getParameter('branch_url'),
                array(), json_encode(array("data"=>
                    array(
                        'course_code'=>$course->getCourseCode()
                    )
                ))
            )->body->url;
            $subject = "Please add ".$course->getCourseName() ." on WhatsDue";
            $htmlBody = $this->container->get('templating')->render(
                'emails/invite.html.twig',
                array(
                    'message'       => $messageHTML,
                    'courseName'    => $course->getCourseName(),
                    'courseCode'    => $course->getCourseCode(),
                    'teacherName'   => $salutation,
                    'link'          => $branchLink
                )
            );
            $meta = array("courseCode"=>$course->getCourseCode());
            $tag = "Invite Users";
            $this->sendBulk($from, $user, $htmlBody, $messageTxt, $subject, $emailList, $tag, $meta);

        }
        return array(
            "success" => true
        );
    }
}
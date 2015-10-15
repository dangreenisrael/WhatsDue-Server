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
use Unirest;

class Email {
    protected $container;

    public function __construct(ContainerInterface $container){
        $this->container = $container;
    }

    public function sendBulk($from, $user, $htmlBody, $txtBody, $subject, $recipients, $tag, $meta){
        $mailer = $this->container->get('mailer');
        $to = array("aaron@whatsdueapp.com" => "Undisclosed Recipients");

        /* Send Email */
        $message = $mailer->createMessage()
            ->setSubject($subject)
            ->setFrom($from)
            ->setTo($to)
            ->setBCC($recipients)
            ->setBody($htmlBody, 'text/html')
        ;
        $mailer->send($message);

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

    public function sendInvites($request, $user){
        $data       = json_decode($request->getContent())->email;
        // Setting sender name as username:
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
        $courses = $this->container->get('doctrine')
            ->getRepository('WhatsdueMainBundle:Course')
            ->findBy(array(
                "id" => $data->courses
            ));

        foreach ($courses as $course){
            $branchLink = Unirest\Request::post(
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
            $this->sendBulk($from, $user, $htmlBody, $message, $subject, $emailsValid, $tag, $meta);
        }

        return array(
            "emails_valid"      =>$emailsValid,
            "emails_invalid"    => $emailsInvalid
        );
    }
}
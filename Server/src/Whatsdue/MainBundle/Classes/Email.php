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


class Email {
    protected $container;

    public function __construct(ContainerInterface $container){
        $this->container = $container;
    }

    public function send($from, $user, $htmlBody, $txtBody, $subject, $recipients, $tag, $meta){
        $mailer = $this->container->get('mailer');

        /* Send Email */
        $message = $mailer->createMessage()
            ->setSubject($subject)
            ->setFrom($from)
            ->setTo($recipients)
            ->setBody($htmlBody, 'text/html')
            //->addPart($txtBody, 'text/plain')
        ;
        $mailer->send($message);

        /* Log Email */

        $emailLog = new EmailLog();
        $emailLog->setSubject($subject);
        $emailLog->setBody($txtBody);
        $emailLog->setRecipients(json_encode($recipients));
        $emailLog->setTag($tag);
        $emailLog->setUser($user->getId());
        $emailLog->setMeta(json_encode($meta));

        $emailLog->setDate($this->container->get('helper')->getUserDateTime());
        $em = $this->container->get('doctrine')->getManager();
        $em->persist($emailLog);
        $em->flush();
    }


}
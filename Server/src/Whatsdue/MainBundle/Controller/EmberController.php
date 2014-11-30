<?php

namespace Whatsdue\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Response;


class EmberController extends Controller
{
    public function indexAction()
    {
        $message = \Swift_Message::newInstance()
            ->setSubject('Hello Email')
            ->setSender("accounts@whatsdueapp.com")
            ->setTo('dan@tlvwebdevelopment.com')
            ->setBody( 'This is a test')
        ;
        $this->get('mailer')->send($message);

        return $this->render('WhatsdueMainBundle:Ember:index.html.twig');
    }

}

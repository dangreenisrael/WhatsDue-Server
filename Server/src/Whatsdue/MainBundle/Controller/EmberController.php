<?php

namespace Whatsdue\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class EmberController extends Controller
{
    public function indexAction()
    {
        return $this->render('WhatsdueMainBundle:Ember:teachers.html.twig');
    }

    public function adminAction()
    {
        return $this->render('WhatsdueMainBundle:Ember:admin.html.twig');
    }

    public function testAction(){

        $message = \Swift_Message::newInstance()
            ->setSubject('Hello Email')
            ->setFrom(array('accounts@whatsdueapp.com'=>'WhatsDue Server'))
            ->setTo('dan@tlvwebdevelopment.com')
            ->setBody(
                "Testing Email"
            )
        ;
        $this->get('mailer')->send($message);

        return $this->render('WhatsdueMainBundle:Ember:test.html.twig');
    }

}

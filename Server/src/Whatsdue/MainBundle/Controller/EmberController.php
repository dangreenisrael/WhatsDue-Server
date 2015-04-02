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

        $user['first']      = "Dan";
        $user['last']       = "Green";
        $user['salutation'] = "Mr.";

        $course['name']     = "English 10";
        $course['code']     = "COURSE";

        return $this->container->get('templating')->renderResponse('WhatsdueMainBundle:Ember:test.html.twig', array(
            'user'      => $user,
            'course'    => $course
        ));
    }

}

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
        echo "Test Passed";
        exit;
        //$user = $this->getUser();
        // $this->container->get('pipedrive')->migrate();
        //return new Response("<br> success");
    }

}

<?php

namespace Whatsdue\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;


class EmberController extends Controller
{
    public function indexAction()
    {
        $index = file_get_contents('teachers/index.html');
        $response = new Response();
        $response->setContent($index);
        return $response;
        //return $this->render('WhatsdueMainBundle:Ember:teachers.html.twig');
    }

    public function adminAction()
    {
        return $this->render('WhatsdueMainBundle:Ember:admin.html.twig');
    }

    public function testAction(){
        echo "Test Passed";
        exit;
    }

}
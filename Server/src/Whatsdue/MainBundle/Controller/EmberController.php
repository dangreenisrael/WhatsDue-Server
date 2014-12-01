<?php

namespace Whatsdue\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Response;


class EmberController extends Controller
{
    public function indexAction()
    {
        return $this->render('WhatsdueMainBundle:Ember:index.html.twig');
    }

    public function adminAction()
    {
        return $this->render('WhatsdueMainBundle:Ember:admin.html.twig');
    }

}

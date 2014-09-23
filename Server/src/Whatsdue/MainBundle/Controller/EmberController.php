<?php

namespace Whatsdue\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class EmberController extends Controller
{
    public function indexAction()
    {
        return $this->render('WhatsdueMainBundle:Ember:index.html.twig');
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: dan
 * Date: 2014-04-17
 * Time: 1:02 PM
 */

namespace Whatsdue\MainBundle\Twig;


use Symfony\Component\DependencyInjection\ContainerInterface;


class AdminExtension extends \Twig_Extension
{

    protected $container;

    protected $doctrine;

    protected $user;

    function __construct(ContainerInterface $container){

        $this-> container    = $container;
        $this-> doctrine     = $container->get('doctrine.orm.entity_manager');
        if ($container->get('security.context')->getToken()){
            $this-> user         = $container->get('security.context')->getToken()->getUser();
        }

    }

    public function getCourses(){

        $courses = $this->doctrine->getRepository('WhatsdueMainBundle:Assignments')
            ->findBy(array(
                'adminID'=>trim($this->user)
            ));
        foreach ($courses as $key => $value){
            $coursesList[] = array(
               "id"     =>$value->getCourseID(),
               "name"  =>$value->getCourseDescription());
        }
        $coursesList = @array_map("unserialize", array_unique(array_map("serialize", $coursesList)));
        return $coursesList;

    }
    public function getGlobals()
    {

        $em = $this->doctrine;

        return array(
            "AdminLinks" =>$this->getCourses(),
        );
    }

    public function getName()
    {
        return 'AdminLinks_extention';
    }
}
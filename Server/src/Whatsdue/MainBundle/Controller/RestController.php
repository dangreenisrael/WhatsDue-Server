<?php
/**
 * Created by PhpStorm.
 * User: dan
 * Date: 2014-04-14
 * Time: 11:59 AM
 */

namespace Whatsdue\MainBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations\View;
use Whatsdue\MainBundle\Entity\Assignments;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class RestController extends Controller{

    /**
     * @return array
     * @View()
     */
    public function getUsersAction(){
        $users = $this->getDoctrine()->getRepository('WhatsdueMainBundle:Assignments')
            ->findAll();

        return array( 'events' => $users );
    }


    /**
     * @return array
     * @View()
     */
    public function getUserAssignmentsAction($adminID){
        $events = $this->getDoctrine()->getRepository('WhatsdueMainBundle:Assignments')
            ->findBy(array(
                'adminID'=>$adminID
            ));

        return array( 'events' => $events );
    }


}
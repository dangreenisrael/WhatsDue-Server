<?php
/**
 * Created by PhpStorm.
 * User: Dan
 * Date: 4/14/15
 * Time: 15:03
 */

namespace Whatsdue\MainBundle\Classes;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
use Unirest;
use Whatsdue\MainBundle\Entity\User;


class Pipedrive {
    protected $container;
    protected $apiBase;
    protected $apiToken;
    protected $urlAppend;
    protected $userID;
    protected $headers;
    protected $salutationKey;
    protected $systemIdKey;

    public function __construct(ContainerInterface $container){
        //Aaron's Id: 586943
        //Dan's ID: 585841
        $this->container     = $container;
            $this->apiBase   = "https://api.pipedrive.com/v1";
        $this->apiToken      = $container->getParameter('pipedrive.apiToken');
        $this->urlAppend     = "?api_token=".$this->apiToken;
        $this->userID        = 586943;
        $this->salutationKey = $container->getParameter('pipedrive.salutationKey');
        $this->systemIdKey   = $container->getParameter('pipedrive.systemIdKey');

        $this->headers = array(
            "Content-Type" => "application/json"
        );
    }



    public function createOrganization($name){
        $body = json_encode(array(
            "name"     =>  $name
        ));
        $target = $this->apiBase."/organizations".$this->urlAppend;
        $response = Unirest\Request::post($target, $this->headers, $body);

        $id = $response->body->data->id;

        return $id;
    }

    public function createPerson($id, $name, $salutation, $email, $organizationId){
        $body = json_encode(array(
            "name"      =>  $name,
            "org_id"    =>  $organizationId,
            "email"     =>  $email,
            $this->salutationKey => $salutation,
            $this->systemIdKey  => $id
        ));

        $target = $this->apiBase."/persons".$this->urlAppend;
        $response = Unirest\Request::post($target, $this->headers, $body);
        $id = $response->body->data->id;

        return $id;
    }

    public function updatePerson($user){

        $body = json_encode(array(
            $this->container->getParameter('pipedrive.InvitesKey') => $user->getUniqueInvitations(),
            $this->container->getParameter('pipedrive.UsersKey') => $user->getUniqueFollowers(),
            $this->container->getParameter('pipedrive.CoursesKey') => $user->getTotalCourses(),
            $this->container->getParameter('pipedrive.AssignmentsKey') => $user->getTotalAssignments(),
        ));

        $personId = $user->getPipedrivePerson();
        $target = $this->apiBase."/persons/$personId".$this->urlAppend;
        Unirest\Request::put($target, $this->headers, $body);
    }

    public function createDeal($title, $organizationId, $personId){
        $body = json_encode(array(
            "title"     =>  $title,
            "person_id" =>  $personId,
            "org_id"    =>  $organizationId
        ));

        $target = $this->apiBase."/deals".$this->urlAppend;
        $response = Unirest\Request::post($target, $this->headers, $body);
        return $response->body->data->id;
    }

    public function updateDeal($user, $stageId){
        $dealId = $user->getPipedriveDeal();
        $currentStage = $user->getPipedriveStage();

        if ($currentStage < $stageId){
            /* Update User*/
            $userManager = $this->container->get('fos_user.user_manager');
            $user->setPipedriveStage($stageId);
            $userManager->updateUser($user);
            $status = "Updated";
        } else{
            $status = "not updated";
        }

        /* Update Pipedrive */
        $body = json_encode(array(
            "id"     =>  $dealId,
            "stage_id" =>  $user->getPipeDriveStage()
        ));

        $target = $this->apiBase."/deals/$dealId".$this->urlAppend;
        $response = Unirest\Request::put($target, $this->headers, $body);
        return $status;

    }

    public function newTeacher($user){

        $name = $user->getFirstName()." ".$user->getLastName();
        $id = $user->getId();
        $salutation = $user->getSalutation();
        $organization = $user->getInstitutionName();
        $email = $user->getEmail();
        $organizationId = $this->createOrganization($organization);
        $personId = $this->createPerson($id, $name, $salutation, $email, $organizationId);
        $dealId = $this->createDeal($name, $organizationId, $personId);

        $user->setPipedriveOrganization($organizationId);
        $user->setPipedrivePerson($personId);
        $user->setPipedriveDeal($dealId);
        $user->setPipedriveStage(1);

        $userManager = $this->container->get('fos_user.user_manager');
        $userManager->updateUser($user);
        return $user;
    }

    public function migrate(){
        $repository = $this->container->get('doctrine')->getRepository('WhatsdueMainBundle:User');
        $teachers = $repository->findAll();
        foreach ($teachers as $teacher){
            $this->newTeacher($teacher);
        }
        return new Response("Migration Complete");
    }



}
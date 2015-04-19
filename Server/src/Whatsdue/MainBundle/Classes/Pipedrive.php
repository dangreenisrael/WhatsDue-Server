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
        $this->container     = $container;
            $this->apiBase   = "https://api.pipedrive.com/v1";
        $this->apiToken      = "eadb95831eb4d720be4d9b5da55175a6825dc0eb";
        $this->urlAppend     = "?api_token=".$this->apiToken;
        $this->userID        = 585841;
        $this->salutationKey = "753d90582477b1bbdb1ebc30f17fb5ff5adc1b14";
        $this->systemIdKey   = "a0d46c35bcefaf966def1fb69902940fb626dd4b";
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

    public function createDeal($title, $organizationId, $personId){
        $body = json_encode(array(
            "title"     =>  $title,
            "person_id" =>  $personId,
            "user_id"   =>  $this->userID,
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

            /* Update Pipedrive */
            $body = json_encode(array(
                "id"     =>  $dealId,
                "stage_id" =>  $stageId
            ));

            $target = $this->apiBase."/deals/$dealId".$this->urlAppend;
            $response = Unirest\Request::put($target, $this->headers, $body);

            return $response;
        } else{
            return "not updated";
        }

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
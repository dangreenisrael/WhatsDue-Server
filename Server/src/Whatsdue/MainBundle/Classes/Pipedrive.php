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
        $this->apiToken      = "c2ab9570e052f2410957809a02d104236862c6ba";
        $this->urlAppend     = "?api_token=".$this->apiToken;
        $this->userID        = 585841;
        $this->salutationKey = "387c7b573c619e43aab6637f5a969a2f658ebcdc";
        $this->systemIdKey   = "b19bf90d8622a54ebf0160f3109db038c2af7b78";
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

    public function updateDeal($dealId, $stageId){
        $body = json_encode(array(
            "id"     =>  $dealId,
            "stage_id" =>  $stageId
        ));

        $target = $this->apiBase."/deals/$dealId".$this->urlAppend;
        $response = Unirest\Request::put($target, $this->headers, $body);
        return $response->body->data->id;
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
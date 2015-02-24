<?php
/**
 * Created by PhpStorm.
 * User: Dan
 * Date: 2/24/15
 * Time: 13:08
 */

namespace Whatsdue\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;




class AuthenticationController extends Controller{
    public function loginAction(Request $request)
    {

        $data = json_decode($this->get("request")->getContent());
        $username = $data->credentials->key;
        $password = $data->credentials->secret;

        var_dump($this->getUser());
        //Try to login user
        $login = $this->container->get('helper')->loginUser($username, $password);
        if ($login){
            http_response_code(200);
            return new Response("Authenticated");
        } else{
            http_response_code(401);
            return new Response("Not Authenticated");

        }

    }
}
<?php
/**
 * Created by PhpStorm.
 * User: dan
 * Date: 2014-07-08
 * Time: 7:26 PM
 */

namespace Whatsdue\MainBundle\Classes;

use Plivo\RestAPI;
class Plivo {

    private $SMS;
    public function __construct(){
        $auth_id = "MAZMQWNDFHZDM2ZGZHOD";
        $auth_token = "NjBhMTI3OWFiYzE3NTExYTE3YzhmN2YxM2M0N2Vj";
        $this->SMS = new RestAPI($auth_id, $auth_token);

    }

    public function sendSMS($destination, $body){
        // Send a message
        $params = array(
            'src' => '14153337777',
            'dst' => $destination,
            'text' => $body,
            'type' => 'sms',
        );
        return $this->SMS->send_message($params);
    }

} 
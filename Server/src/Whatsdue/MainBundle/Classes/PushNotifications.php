<?php
/**
 * Created by PhpStorm.
 * User: dan
 * Date: 2014-07-08
 * Time: 7:26 PM
 */

namespace Whatsdue\MainBundle\Classes;

define( 'API_ACCESS_KEY', "AIzaSyBYoGvX_ciWo2V8_1UE2ts_s3vKC890bjc" );
class PushNotifications {

    public function androidNotifications($title, $message, $tickerText, $pushIds, $alert, $assignmentId){
        $pushIds = str_replace("|","_",$pushIds);
        // prep the bundle
        $msg = array
        (
            'title'			=> $title,
            'message' 		=> $message,
            'tickerText'	=> $tickerText,
            'alert'         => $alert,
            'assignmentId'  => $assignmentId,
            'vibrate'	    => 1,
            'sound'		    => 1
        );

        $fields = array
        (
            'registration_ids' 	=> $pushIds,
            'data'				=> $msg
        );

        $headers = array
        (
            'Authorization: key=' . API_ACCESS_KEY,
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, 'https://android.googleapis.com/gcm/send' );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
        $result = curl_exec($ch );
        curl_close( $ch );
    }
} 
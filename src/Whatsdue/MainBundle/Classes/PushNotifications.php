<?php
/**
 * Created by PhpStorm.
 * User: dan
 * Date: 2014-07-08
 * Time: 7:26 PM
 */

namespace Whatsdue\MainBundle\Classes;
use RMS\PushNotificationsBundle\Message\iOSMessage;
use Symfony\Component\DependencyInjection\ContainerInterface;

define( 'API_ACCESS_KEY', "AIzaSyDbUaBlRrYZpg2GPLqZTls-SAGIX1cBDek" );
class PushNotifications {

    public $container;

    public function __construct(ContainerInterface $container){
            $this->container = $container;
        }

    private function androidNotifications($title, $message, $pushIds){
        /* prep the bundle */
        $msg = array
        (
            'title'			=> $title,
            'message' 		=> $message,
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

    private function iosNotifications($text, $pushIds){
        $message = new iOSMessage();
        $message->setMessage($text);

        foreach ($pushIds as $pushId){
            $message->setDeviceIdentifier($pushId);
            $this->container->get('rms_push_notifications')->send($message);
        }

    }

    public function sendChangeNotifications($title, $message, $consumerIds){
        $consumers = $this->container->get('doctrine')->getManager()->getRepository('WhatsdueMainBundle:Consumer')->findById($consumerIds);
        $consumersToNotify = [];
        if ($consumers){
            foreach($consumers as $consumer){
                $timePreference = $consumer->getNotificationTimeUTC();
                $timeCurrent    = date('Hi'); // 'Hi' is a date format
                if ($timeCurrent > $timePreference){
                    $consumersToNotify[] = $consumer;
                }
            }
        }
        $this->sendNotifications($title, $message, $consumersToNotify);
    }

    public function sendNotifications($title, $message, $consumers){
        $androidUsers = [];
        $iosUsers = [];
        $deviceIds = [];
        if ($consumers){
            foreach($consumers as $consumer){
                $deviceIds = array_merge($deviceIds,json_decode($consumer->getDevices(), true));
            }
        }
        $devices = $this->container->get('doctrine')->getManager()->getRepository('WhatsdueMainBundle:Device')->findById($deviceIds);
        foreach($devices as $device){
            if ($device->getPlatform() == "Android"){
                $androidUsers[] = $device->getPushId();
            } else{
                $iosUsers[] = $device->getPushId();
            }
        }

        /*
         * Send the Notifications
         */
        $this->androidNotifications($title, $message, $androidUsers);
        $this->iosNotifications($message, $iosUsers);
    }
} 
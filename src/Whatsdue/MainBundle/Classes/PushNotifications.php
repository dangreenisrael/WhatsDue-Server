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

    private function androidNotifications( $message, $pushIds, $vibrationPattern, $actions, $sound){
        /* prep the bundle */

        if ($vibrationPattern){
            $vibrate = true;
        } else{
            $vibrate = null;
        }
        $msg = array
        (
            'title'			    => "WhatsDue",
            'message' 		    => $message,
            'style'             => 'inbox',
            'sound'             => $sound,
            'vibrate'           => $vibrate,
            'vibrationPattern'  => $vibrationPattern,
            'actions'           => $actions,

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
        return $result;
    }

    private function iosNotifications($text, $pushIds){
        $message = new iOSMessage();
        $message->setMessage($text);

        foreach ($pushIds as $pushId){
            $message->setDeviceIdentifier($pushId);
            $this->container->get('rms_push_notifications')->send($message);
        }

    }

    public function sendChangeNotifications($message, $students){
        $studentsToNotify = [];
        if ($students){
            foreach($students as $student){
                $timePreference = $student->getNotificationTimeUTC();
                $allNotifications = $student->getNotificationUpdates();
                $timeCurrent    = date('Hi'); // 'Hi' is a date format
                if (($timeCurrent > $timePreference) || $allNotifications){
                    $studentsToNotify[] = $student;
                }
            }
        }
        $this->sendNotifications( $message, $studentsToNotify);
    }

    public function sendNotifications($messages, $students){
        $androidUsers = [];
        $iosUsers = [];
        $devices = [];
        if ($students){
            foreach($students as $student){
                $studentDevices = $student->getDevices();
                foreach($studentDevices as $studentDevice){
                    $devices[] = $studentDevice;
                }
            }
        }

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

        /* Android */
        $vibrationPattern  =  array(
            0,100,200,100,100,100,100,100,200,100,500,100,225,100
        );
        $noVibration = array(0);
        $singleVibrate = array(
            0,100,100,200
        );
        $actions = array(
            array(
                "icon" => "icon",
                "title" => "See More",
                "callback" => null
            )
        );


        if (!is_array($messages)){
            $this->androidNotifications($messages, $androidUsers, $singleVibrate, $actions, null);
            $this->iosNotifications($messages, $iosUsers);
        } else{
            /* iOS */
            $multilineMessage = "";
            foreach ($messages as $message){
                 $multilineMessage .= "$message\n";
            }
            $this->iosNotifications($multilineMessage, $iosUsers);

            /* Android */
            foreach ($messages as $index => $message){
                if ($index == 0){
                    $this->androidNotifications($message, $androidUsers, $vibrationPattern, $actions , null);
                } else{
                    $this->androidNotifications($message, $androidUsers, $noVibration, $actions, false);
                }
            }
        }
    }
} 
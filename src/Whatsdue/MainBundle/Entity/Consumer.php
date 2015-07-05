<?php

namespace Whatsdue\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Consumers
 *
 * @ORM\Table(name="Consumers"))
 * @ORM\Entity
 */
class Consumer
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="devices", type="string", length=1000)
     */
    private $devices;

    /**
     * @var string
     *
     * @ORM\Column(name="courses", type="string", length=1000)
     */
    private $courses;

    /**
     * @var boolean
     *
     * @ORM\Column(name="notifications", type="boolean")
     */
    private $notifications;
    /**
     * @var boolean
     *
     * @ORM\Column(name="notificationUpdates", type="boolean")
     */
    private $notificationUpdates;

    /**
     * @var string
     *
     * @ORM\Column(name="notificationTimeLocal", type="string", length=255)
     */
    private $notificationTimeLocal;

    /**
     * @var string
     *
     * @ORM\Column(name="notificationTimeUTC", type="string", length=255)
     */
    private $notificationTimeUtc;




    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set devices
     *
     * @param string $devices
     *
     * @return Consumer
     */
    public function setDevices($devices)
    {
        $this->devices = $devices;

        return $this;
    }

    /**
     * Get devices
     *
     * @return string
     */
    public function getDevices()
    {
        return $this->devices;
    }

    /**
     * Set courses
     *
     * @param string $courses
     *
     * @return Consumer
     */
    public function setCourses($courses)
    {
        $this->courses = $courses;

        return $this;
    }

    /**
     * Get courses
     *
     * @return string
     */
    public function getCourses()
    {
        return $this->courses;
    }

    /**
     * Set notifications
     *
     * @param boolean $notifications
     *
     * @return Consumer
     */
    public function setNotifications($notifications)
    {
        $this->notifications = $notifications;

        return $this;
    }

    /**
     * Get notifications
     *
     * @return boolean
     */
    public function getNotifications()
    {
        return $this->notifications;
    }

    /**
     * Set notificationTimeLocal
     *
     * @param string $notificationTimeLocal
     *
     * @return Consumer
     */
    public function setNotificationTimeLocal($notificationTimeLocal)
    {
        $this->notificationTimeLocal = $notificationTimeLocal;

        return $this;
    }

    /**
     * Get notificationTimeLocal
     *
     * @return string
     */
    public function getNotificationTimeLocal()
    {
        return $this->notificationTimeLocal;
    }

    /**
     * Set notificationTimeUtc
     *
     * @param string $notificationTimeUtc
     *
     * @return Consumer
     */
    public function setNotificationTimeUtc($notificationTimeUtc)
    {
        $this->notificationTimeUtc = $notificationTimeUtc;

        return $this;
    }

    /**
     * Get notificationTimeUtc
     *
     * @return string
     */
    public function getNotificationTimeUtc()
    {
        return $this->notificationTimeUtc;
    }

    /**
     * Set updates
     *
     * @param boolean $notificationUpdates
     *
     * @return Consumer
     */
    public function setNotificationUpdates($notificationUpdates)
    {
        $this->notificationUpdates = $notificationUpdates;

        return $this;
    }

    /**
     * Get updates
     *
     * @return boolean
     */
    public function getNotificationUpdates()
    {
        return $this->notificationUpdates;
    }

    public function cleanObject(){
    }
}

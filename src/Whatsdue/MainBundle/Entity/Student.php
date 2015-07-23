<?php

namespace Whatsdue\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Whatsdue\MainBundle\Entity\Course;
use Whatsdue\MainBundle\Entity\Device;
use Whatsdue\MainBundle\Entity\StudentAssignment;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;


/**
 * Students
 *
 * @ORM\Table(name="student")
 * @ORM\Entity
 * @ExclusionPolicy("all")
 */
class Student
{

    /**
     * @ORM\OneToMany(targetEntity="StudentAssignment", mappedBy="student")
     **/
    private $studentAssignments;

    /**
     * @ORM\OneToMany(targetEntity="Device", mappedBy="student")
     **/
    private $devices;


    /**
     * @ORM\ManyToMany(targetEntity="Course", mappedBy="students")
     **/
    private $courses;

    public function __construct() {
        $this->studentAssignments = new ArrayCollection();
        $this->devices = new ArrayCollection();
        $this->courses = new ArrayCollection();
    }

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Expose
     */
    private $id;

    /**
     * @var boolean
     *
     * @ORM\Column(name="notifications", type="boolean")
     * @Expose
     */
    private $notifications;
    /**
     * @var boolean
     *
     * @ORM\Column(name="notificationUpdates", type="boolean")
     * @Expose
     */
    private $notificationUpdates;

    /**
     * @var string
     *
     * @ORM\Column(name="notificationTimeLocal", type="string", length=255)
     * @Expose
     */
    private $notificationTimeLocal;

    /**
     * @var string
     *
     * @ORM\Column(name="notificationTimeUTC", type="string", length=255)
     * @Expose
     */
    private $notificationTimeUtc;

    /**
     * @var string
     *
     * @ORM\Column(name="firstName", type="string", length=50)
     * @Expose
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="lastName", type="string", length=50)
     * @Expose
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="role", type="string", length=50)
     * @Expose
     */
    private $role;

    /**
     * @var string
     *
     * @ORM\Column(name="over12", type="boolean")
     * @Expose
     */
    private $over12;

    /**
     * @var string
     *
     * @ORM\Column(name="parentEmail", type="string", length=255)
     * @Expose
     */
    private $parentEmail;


    /**
     * @var string
     *
     * @ORM\Column(name="signupDate", type="string")
     * @Expose
     */
    private $signupDate;




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
     * Set notifications
     *
     * @param boolean $notifications
     *
     * @return Student
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
     * @return Student
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
     * @return Student
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
     * @return Student
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

    /**
     * Add course
     *
     * @param \Whatsdue\MainBundle\Entity\Course $course
     *
     * @return Student
     */
    public function addCourse(Course $course)
    {
        $this->courses[] = $course;

        return $this;
    }

    /**
     * Remove course
     *
     * @param \Whatsdue\MainBundle\Entity\Course $course
     */
    public function removeCourse(Course $course)
    {
        $this->courses->removeElement($course);
    }

    /**
     * Get courses
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCourses()
    {
        return $this->courses;
    }

    /**
     * Add device
     *
     * @param \Whatsdue\MainBundle\Entity\Device $device
     *
     * @return Student
     */
    public function addDevice(Device $device)
    {
        $this->devices[] = $device;

        return $this;
    }

    /**
     * Remove device
     *
     * @param \Whatsdue\MainBundle\Entity\Device $device
     */
    public function removeDevice(Device $device)
    {
        $this->devices->removeElement($device);
    }

    /**
     * Get devices
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDevices()
    {
        return $this->devices;
    }



    /**
     * Add studentAssignment
     *
     * @param \Whatsdue\MainBundle\Entity\StudentAssignment $studentAssignment
     *
     * @return Student
     */
    public function addStudentAssignment(StudentAssignment $studentAssignment)
    {
        $this->studentAssignments[] = $studentAssignment;

        return $this;
    }

    /**
     * Remove studentAssignment
     *
     * @param \Whatsdue\MainBundle\Entity\StudentAssignment $studentAssignment
     */
    public function removeStudentAssignment(StudentAssignment $studentAssignment)
    {
        $this->studentAssignments->removeElement($studentAssignment);
    }

    /**
     * Get studentAssignments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getStudentAssignments()
    {
        return $this->studentAssignments;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return Student
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return Student
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set role
     *
     * @param string $role
     *
     * @return Student
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set over12
     *
     * @param boolean $over12
     *
     * @return Student
     */
    public function setOver12($over12)
    {
        $this->over12 = $over12;

        return $this;
    }

    /**
     * Get over12
     *
     * @return boolean
     */
    public function getOver12()
    {
        return $this->over12;
    }

    /**
     * Set parentEmail
     *
     * @param string $parentEmail
     *
     * @return Student
     */
    public function setParentEmail($parentEmail)
    {
        $this->parentEmail = $parentEmail;

        return $this;
    }

    /**
     * Get parentEmail
     *
     * @return string
     */
    public function getParentEmail()
    {
        return $this->parentEmail;
    }

    /**
     * Set signupDate
     *
     * @param string $signupDate
     *
     * @return Student
     */
    public function setSignupDate($signupDate)
    {
        $this->signupDate = $signupDate;

        return $this;
    }

    /**
     * Get signupDate
     *
     * @return string
     */
    public function getSignupDate()
    {
        return $this->signupDate;
    }
}

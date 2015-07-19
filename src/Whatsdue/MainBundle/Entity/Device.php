<?php

namespace Whatsdue\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Whatsdue\MainBundle\Entity\Student;


/**
 * Devices
 *
 * @ORM\Table(name="device")
 * @ORM\Entity
 */
class Device
{

    /**
     * @ORM\ManyToOne(targetEntity="Student", inversedBy="devices")
     * @ORM\JoinColumn(name="studentId", referencedColumnName="id")
     **/
    private $student;


    public function __construct() {
        $this->student = new ArrayCollection();
    }

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
     * @ORM\Column(name="uuid", type="string", length=255)
     */
    private $uuid;


    /**
     * @var string
     *
     * @ORM\Column(name="platform", type="string", length=255)
     */
    private $platform;

    /**
     * @var string
     *
     * @ORM\Column(name="pushId", type="string", length=255)
     */
    private $pushId;

    /**
     * @var string
     *
     * @ORM\Column(name="studentId", type="integer", length=11)
     */
    private $studentId;

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
     * Set uuid
     *
     * @param string $uuid
     * @return Device
     */
    public function setUuid($uuid)
    {
        $this->uuid = $uuid;

        return $this;
    }

    /**
     * Get uuid
     *
     * @return string 
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * Set platform
     *
     * @param string $platform
     * @return Device
     */
    public function setPlatform($platform)
    {
        $this->platform = $platform;

        return $this;
    }

    /**
     * Get platform
     *
     * @return string 
     */
    public function getPlatform()
    {
        return $this->platform;
    }

    /**
     * Set pushId
     *
     * @param string $pushId
     * @return Device
     */
    public function setPushId($pushId)
    {
        $this->pushId = $pushId;

        return $this;
    }

    /**
     * Get pushId
     *
     * @return string 
     */
    public function getPushId()
    {
        return $this->pushId;
    }




    public function cleanObject(){
    }

    /**
     * Set studentId
     *
     * @param string $studentId
     *
     * @return Device
     */
    public function setStudentId($studentId)
    {
        $this->studentId = $studentId;

        return $this;
    }

    /**
     * Get studentId
     *
     * @return string
     */
    public function getStudentId()
    {
        return $this->studentId;
    }

    /**
     * Set course
     *
     * @param \Whatsdue\MainBundle\Entity\Student $student
     *
     * @return Device
     */
    public function setCourse(Student $student = null)
    {
        $this->student = $student;

        return $this;
    }

    /**
     * Get course
     *
     * @return \Whatsdue\MainBundle\Entity\Student
     */
    public function getStudent()
    {
        return $this->student;
    }

    /**
     * Set student
     *
     * @param \Whatsdue\MainBundle\Entity\Student $student
     *
     * @return Device
     */
    public function setStudent(\Whatsdue\MainBundle\Entity\Student $student = null)
    {
        $this->student = $student;

        return $this;
    }
}

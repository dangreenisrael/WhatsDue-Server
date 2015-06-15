<?php

namespace Whatsdue\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\DependencyInjection\ContainerInterface;



/**
 * Courses
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Whatsdue\MainBundle\Entity\CoursesRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Courses
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="courseName", type="string", length=50)
     */
    private $courseName;

    /**
     * @var string
     *
     * @ORM\Column(name="courseCode", type="string", length=10, nullable=true)
     */
    private $courseCode;

    /**
     * @var string
     *
     * @ORM\Column(name="instructorName", type="string", length=50)
     */
    private $instructorName;


    /**
     * @var string
     *
     * @ORM\Column(name="adminId", type="string", length=255)
     */
    private $adminId;


    /**
     * @var string
     *
     * @ORM\Column(name="deviceIds", type="text", nullable=true)
     */
    private $deviceIds;

    /**
     * @var string
     *
     * @ORM\Column(name="consumerIds", type="text", nullable=true)
     */
    private $consumerIds;

    /**
     * @var string
     *
     * @ORM\Column(name="schoolName", type="text")
     */
    private $schoolName;

    /**
     * @var boolean
     *
     * @ORM\Column(name="archived", type="boolean", nullable=true)
     */
    private $archived;


    /**
     * @var integer
     *
     * @ORM\Column(name="createdAt", type="integer", length=255)
     */
    private $createdAt;

    /**
     * @var integer
     *
     * @ORM\Column(name="lastUpdated", type="integer", length=255, nullable=true)
     */
    private $lastUpdated;

    /**
     * @var integer
     *
     * @ORM\Column(name="lastModified", type="integer", length=255)
     */
    private $lastModified;




    private function timestamp(){
        $date = new \DateTime();
        return $date->format('U');
    }


    /**
     * @ORM\PrePersist
     */

    public function setCreatedAtValue()
    {
        $this->createdAt = $this->timestamp();
        $this->lastModified = $this->timestamp();
    }


    /**
     * @ORM\PreUpdate
     */
    public function setLastUpdatedValue()
    {
        $this->lastUpdated = $this->timestamp();
        $this->lastModified = $this->timestamp();

    }

    /**
     * Get lastModified
     *
     * @return integer
     */
    public function getLastModified()
    {
        return $this->lastModified;
    }

    /**
     * Get lastUpdated
     *
     * @return integer
     */
    public function getLastUpdated()
    {
        return $this->lastUpdated;
    }

    /**
     * Get createdAt
     *
     * @return integer
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }


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
     * Set courseName
     *
     * @param string $courseName
     * @return Courses
     */
    public function setCourseName($courseName)
    {
        $this->courseName = $courseName;

        return $this;
    }

    /**
     * Get courseName
     *
     * @return string 
     */
    public function getCourseName()
    {
        return $this->courseName;
    }

    /**
     * Set adminId
     *
     * @param string $adminId
     * @return Courses
     */
    public function setAdminId($adminId)
    {
        $this->adminId = $adminId;

        return $this;
    }

    /**
     * Get adminId
     *
     * @return string 
     */
    public function getAdminId()
    {
        return $this->adminId;
    }




    /**
     * Set instructorName
     *
     * @param string $instructorName
     * @return Courses
     */
    public function setInstructorName($instructorName)
    {
        $this->instructorName = $instructorName;

        return $this;
    }

    /**
     * Get instructorName
     *
     * @return string
     */
    public function getInstructorName()
    {
        return $this->instructorName;
    }

    /**
     * Set createdAt
     *
     * @param integer $createdAt
     * @return Courses
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Set lastUpdated
     *
     * @param integer $lastUpdated
     * @return Courses
     */
    public function setLastUpdated($lastUpdated)
    {
        $this->lastUpdated = $lastUpdated;

        return $this;
    }

    /**
     * Set lastModified
     *
     * @param integer $lastModified
     * @return Courses
     */
    public function setLastModified($lastModified)
    {
        $this->lastModified = $lastModified;

        return $this;
    }



    /**
     * Set deviceIds
     *
     * @param string $deviceIds
     * @return Courses
     */
    public function setDeviceIds($deviceIds)
    {
        $this->deviceIds = $deviceIds;

        return $this;
    }

    /**
     * Get deviceIds
     *
     * @return string 
     */
    public function getDeviceIds()
    {
        return $this->deviceIds;
    }

    /**
     * Set archived
     *
     * @param boolean $archived
     * @return Assignments
     */
    public function setArchived($archived)
    {
        $this->archived = $archived;

        return $this;
    }

    /**
     * Get archived
     *
     * @return boolean
     */
    public function getArchived()
    {
        return $this->archived;
    }

    /**
     * @ORM\PrePersist
     */
    public function setArchivedValue()
    {
        $this->archived = 0;
    }



    /**
     * Set schoolName
     *
     * @param string $schoolName
     * @return Courses
     */
    public function setSchoolName($schoolName)
    {
        $this->schoolName = $schoolName;

        return $this;
    }

    /**
     * Get schoolName
     *
     * @return string 
     */
    public function getSchoolName()
    {
        return $this->schoolName;
    }

    /**
     * Set courseCode
     *
     * @param string $courseCode
     * @return Courses
     */
    public function setCourseCode($courseCode)
    {
        $this->courseCode = $courseCode;

        return $this;
    }

    /**
     * Get courseCode
     *
     * @return string 
     */
    public function getCourseCode()
    {
        return $this->courseCode;
    }

    /**
     * Set consumerIds
     *
     * @param string $consumerIds
     *
     * @return Courses
     */
    public function setConsumerIds($consumerIds)
    {
        $this->consumerIds = $consumerIds;

        return $this;
    }

    /**
     * Get consumerIds
     *
     * @return string
     */
    public function getConsumerIds()
    {
        return $this->consumerIds;
    }
}
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
     * @ORM\Column(name="courseName", type="string", length=255)
     */
    private $courseName;

    /**
     * @var string
     *
     * @ORM\Column(name="courseDescription", type="string", length=500)
     */
    private $courseDescription;


    /**
     * @var string
     *
     * @ORM\Column(name="adminId", type="string", length=255)
     */
    private $adminId;

    /**
     * @var string
     *
     * @ORM\Column(name="androidUsers", type="text", nullable=true)
     */
    private $androidUsers;

    /**
     * @var string
     *
     * @ORM\Column(name="iosUsers", type="text", nullable=true)
     */
    private $iosUsers;


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
     * Set courseDescription
     *
     * @param string $courseDescription
     * @return Courses
     */
    public function setCourseDescription($courseDescription)
    {
        $this->courseDescription = $courseDescription;

        return $this;
    }

    /**
     * Get courseDescription
     *
     * @return string
     */
    public function getCourseDescription()
    {
        return $this->courseDescription;
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
     * Set androidUsers
     *
     * @param string $androidUsers
     * @return Courses
     */
    public function setAndroidUsers($androidUsers)
    {
        $this->androidUsers = $androidUsers;

        return $this;
    }

    /**
     * Get androidUsers
     *
     * @return string 
     */
    public function getAndroidUsers()
    {
        return $this->androidUsers;
    }

    /**
     * Set iosUsers
     *
     * @param string $iosUsers
     * @return Courses
     */
    public function setIosUsers($iosUsers)
    {
        $this->iosUsers = $iosUsers;

        return $this;
    }

    /**
     * Get iosUsers
     *
     * @return string 
     */
    public function getIosUsers()
    {
        return $this->iosUsers;
    }
}

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
     * Set assignmentName
     *
     * @param string $assignmentName
     * @return Courses
     */
    public function setAssignmentName($assignmentName)
    {
        $this->assignmentName = $assignmentName;

        return $this;
    }

    /**
     * Get assignmentName
     *
     * @return string 
     */
    public function getAssignmentName()
    {
        return $this->assignmentName;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Courses
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set dueDate
     *
     * @param string $dueDate
     * @return Courses
     */
    public function setDueDate($dueDate)
    {
        $this->dueDate = $dueDate;

        return $this;
    }

    /**
     * Get dueDate
     *
     * @return string 
     */
    public function getDueDate()
    {
        return $this->dueDate;
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
}

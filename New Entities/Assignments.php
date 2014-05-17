<?php

namespace Whatsdue\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Assignments
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Whatsdue\MainBundle\Entity\AssignmentsRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Assignments
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
     * @var integer
     *
     * @ORM\Column(name="courseId", type="integer")
     */
    private $courseId;


    /**
     * @var string
     *
     * @ORM\Column(name="assignmentName", type="string", length=500)
     */
    private $assignmentName;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="dueDate", type="string", length=255)
     */
    private $dueDate;

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
    public function setUpdatedAtValue()
    {
        $this->lastUpdated = $this->timestamp();
        $this->lastModified = $this->timestamp();

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
     * Set courseId
     *
     * @param integer $courseId
     * @return Assignments
     */
    public function setcourseId($courseId)
    {
        $this->courseId = $courseId;

        return $this;
    }

    /**
     * Get courseId
     *
     * @return integer
     */
    public function getcourseId()
    {
        return $this->courseId;
    }



    /**
     * Set assignmentName
     *
     * @param string $assignmentName
     * @return Assignments
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
     * @return Assignments
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
     * @return Assignments
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


}

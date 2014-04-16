<?php

namespace Whatsdue\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Assignments
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Whatsdue\MainBundle\Entity\AssignmentsRepository")
 */
class Assignments
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
     * @ORM\Column(name="courseID", type="string", length=255)
     */
    private $courseID;

    /**
     * @var string
     *
     * @ORM\Column(name="adminID", type="string", length=255)
     */
    private $adminID;

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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set courseID
     *
     * @param string $courseID
     * @return Assignments
     */
    public function setCourseID($courseID)
    {
        $this->courseID = $courseID;

        return $this;
    }

    /**
     * Get courseID
     *
     * @return string 
     */
    public function getCourseID()
    {
        return $this->courseID;
    }

    /**
     * Set adminID
     *
     * @param string $adminID
     * @return Assignments
     */
    public function setAdminID($adminID)
    {
        $this->adminID = $adminID;

        return $this;
    }

    /**
     * Get adminID
     *
     * @return string 
     */
    public function getAdminID()
    {
        return $this->adminID;
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

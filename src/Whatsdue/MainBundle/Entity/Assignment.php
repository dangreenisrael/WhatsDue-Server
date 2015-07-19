<?php

namespace Whatsdue\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Whatsdue\MainBundle\Entity\Course;
use Whatsdue\MainBundle\Entity\StudentAssignment;

/**
 * Assignment
 *
 * @ORM\Table(name="assignment")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class Assignment
{

    /**
     * @ORM\ManyToOne(targetEntity="Course", inversedBy="assignments")
     * @ORM\JoinColumn(name="courseId", referencedColumnName="id")
     **/
    private $course;

    /**
     * @ORM\OneToMany(targetEntity="StudentAssignment", mappedBy="assignment", fetch="EXTRA_LAZY")
     **/
    private $studentAssignments;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->studentAssignments = new ArrayCollection();
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
     * @var integer
     *
     * @ORM\Column(name="courseId", type="integer")
     */
    private $courseId;


    /**
     * @var string
     *
     * @ORM\Column(name="adminId", type="string", length=255)
     */
    private $adminId;

    /**
     * @var string
     *
     * @ORM\Column(name="assignmentName", type="string", length=50)
     */
    private $assignmentName;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="dueDate", type="string", length=255)
     */
    private $dueDate;

    /**
     * @var boolean
     *
     * @ORM\Column(name="archived", type="boolean", nullable=true)
     */
    private $archived;

    /**
     * @var boolean
     *
     * @ORM\Column(name="time_visible", type="boolean", nullable=true)
     */
    private $timeVisible;

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
     * Set courseId
     *
     * @param integer $courseId
     * @return Assignment
     */
    public function setCourseId($courseId)
    {
        $this->courseId = $courseId;

        return $this;
    }

    /**
     * Get courseId
     *
     * @return integer
     */
    public function getCourseId()
    {
        return $this->courseId;
    }

    /**
     * Set adminId
     *
     * @param string $adminId
     * @return Assignment
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
     * @return Assignment
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
     * @return Assignment
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
     * @return Assignment
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
     * Set createdAt
     *
     * @param integer $createdAt
     * @return Assignment
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
     * @return Assignment
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
     * @return Assignment
     */
    public function setLastModified($lastModified)
    {
        $this->lastModified = $lastModified;

        return $this;
    }

    /**
     * Set archived
     *
     * @param boolean $archived
     * @return Assignment
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
     * Set Time Visible
     *
     * @param boolean $timeVisible
     * @return Assignment
     */
    public function setTimeVisible($timeVisible)
    {
        $this->timeVisible = $timeVisible;

        return $this;
    }

    /**
     * Get Time Visible
     *
     * @return boolean
     */
    public function getTimeVisible()
    {
        return $this->timeVisible;
    }

    /**
     * @ORM\PrePersist
     */
    public function setArchivedValue()
    {
        $this->archived = 0;
    }

    /**
     * Set course
     *
     * @param \Whatsdue\MainBundle\Entity\Course $course
     *
     * @return Assignment
     */
    public function setCourse(Course $course = null)
    {
        $this->course = $course;

        return $this;
    }

    /**
     * Get course
     *
     * @return \Whatsdue\MainBundle\Entity\Course
     */
    public function getCourse()
    {
        return $this->course;
    }

    public function cleanObject(){
        $this->course = null;
    }


    /**
     * Add studentAssignment
     *
     * @param \Whatsdue\MainBundle\Entity\StudentAssignment $studentAssignment
     *
     * @return Assignment
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
}

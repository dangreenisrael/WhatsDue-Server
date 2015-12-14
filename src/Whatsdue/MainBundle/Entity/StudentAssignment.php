<?php

namespace Whatsdue\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Whatsdue\MainBundle\Entity\Assignment;
use Whatsdue\MainBundle\Entity\Student;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * StudentAssignment
 *
 * @ORM\Table(name="student_assignment")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 * @ExclusionPolicy("all")
 * @ORM\Entity(repositoryClass="StudentAssignmentRepository")
 */
class StudentAssignment
{

    /**
     * @ORM\ManyToOne(targetEntity="Assignment", inversedBy="studentAssignments")
     * @ORM\JoinColumn(name="assignment", referencedColumnName="id")
     **/
    private $assignment;

    /**
     * @ORM\ManyToOne(targetEntity="Student", inversedBy="studentAssignments")
     * @ORM\JoinColumn(name="student", referencedColumnName="id")
     **/
    private $student;


    /**
     * @Expose
     */
    private $studentId;

    /**
     * @Expose
     */
    private $assignmentId;


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
     * @ORM\Column(name="completed", type="boolean", nullable=true)
     * @Expose
     */
    private $completed;

    /**
     * @var integer
     * @ORM\Column(name="completedDate", type="integer", length=50,  nullable=true)
     * @Expose
     */
    private $completedDate;

    /**
     * @var boolean
     * @ORM\Column(name="seen", type="boolean", nullable=true)
     * @Expose
     */
    private $seen;

    /**
     * @var integer
     * @ORM\Column(name="seenDate", type="integer", length=50,  nullable=true)
     * @Expose
     */
    private $seenDate;


    /**
     * @ORM\PostLoad
     */
    public function loadEntityList(){
        $this->assignmentId = $this->getAssignment()->getId();
        $this->studentId = $this->getStudent()->getId();
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
     * Set completed
     *
     * @param boolean $completed
     *
     * @return StudentAssignment
     */
    public function setCompleted($completed)
    {
        $this->completed = $completed;

        return $this;
    }

    /**
     * Get completed
     *
     * @return boolean
     */
    public function getCompleted()
    {
        return $this->completed;
    }


    /**
     * Get completedDate
     *
     * @return integer
     */
    public function getCompletedDate()
    {
        return $this->completedDate;
    }

    /**
     * Set completedDate
     *
     * @param integer $completedDate
     *
     * @return StudentAssignment
     */
    public function setCompletedDate($completedDate)
    {
        $this->completedDate = $completedDate;
        return $this;
    }

    /**
     * Get seen
     *
     * @return boolean
     */
    public function getSeen()
    {
        return $this->seen;
    }

    /**
     * Set seen
     *
     * @param boolean $seen
     *
     * @return StudentAssignment
     */
    public function setSeen($seen)
    {
        $this->seen = $seen;
        return $this;
    }


    /**
     * Get seenDate
     *
     * @return integer
     */
    public function getSeenDate()
    {
        return $this->seenDate;
    }

    /**
     * Set seenDate
     *
     * @param integer $seenDate
     *
     * @return StudentAssignment
     */
    public function setSeenDate($seenDate)
    {
        $this->seenDate = $seenDate;
        return $this;
    }





    /**
     * Set assignment
     *
     * @param \Whatsdue\MainBundle\Entity\Assignment $assignment
     *
     * @return StudentAssignment
     */
    public function setAssignment(Assignment $assignment = null)
    {
        $this->assignment = $assignment;

        return $this;
    }

    /**
     * Get assignment
     *
     * @return \Whatsdue\MainBundle\Entity\Assignment
     */
    public function getAssignment()
    {
        return $this->assignment;
    }

    /**
     * Set student
     *
     * @param \Whatsdue\MainBundle\Entity\Student $student
     *
     * @return StudentAssignment
     */
    public function setStudent(Student $student = null)
    {
        $this->student = $student;

        return $this;
    }

    /**
     * Get student
     *
     * @return \Whatsdue\MainBundle\Entity\Student
     */
    public function getStudent()
    {
        return $this->student;
    }
}

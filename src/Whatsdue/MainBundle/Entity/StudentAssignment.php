<?php

namespace Whatsdue\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Whatsdue\MainBundle\Entity\Assignment;
use Whatsdue\MainBundle\Entity\Student;


/**
 * StudentAssignment
 *
 * @ORM\Table(name="student_assignment")
 * @ORM\Entity
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
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var boolean
     *
     * @ORM\Column(name="completed", type="boolean", nullable=true)
     */
    private $completed;

    /**
     * @var string
     *
     * @ORM\Column(name="dateCompleted", type="string", length=50,  nullable=true)
     */
    private $dateCompleted;


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
     * Set dateCompleted
     *
     * @param string $dateCompleted
     *
     * @return StudentAssignment
     */
    public function setTimeCompleted($dateCompleted)
    {
        $this->dateCompleted = $dateCompleted;

        return $this;
    }

    /**
     * Get dateCompleted
     *
     * @return string
     */
    public function getDateCompleted()
    {
        return $this->dateCompleted;
    }

    /**
     * Set dateCompleted
     *
     * @param string $dateCompleted
     *
     * @return StudentAssignment
     */
    public function setDateCompleted($dateCompleted)
    {
        $this->dateCompleted = $dateCompleted;

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

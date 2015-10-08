<?php

namespace Whatsdue\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
//use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Whatsdue\MainBundle\Entity\Assignment;
use Whatsdue\MainBundle\Entity\Student;
use Whatsdue\MainBundle\Entity\User;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;


/**
 * Course
 *
 * @ORM\Table(name="course")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass="Whatsdue\MainBundle\Entity\CourseRepository")
 * @ExclusionPolicy("all")
 */
class Course
{

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="course", cascade={"all"})
     * @ORM\JoinColumn(name="userId", referencedColumnName="id", nullable=true)
     **/
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="Assignment", mappedBy="course", fetch="EXTRA_LAZY", cascade={"all"})
     **/
    private $assignments;

    /**
     * @ORM\ManyToMany(targetEntity="Student", inversedBy="course", cascade={"all"})
     * @ORM\JoinTable(name="course_student",
     *  joinColumns={@ORM\JoinColumn(onDelete="CASCADE")},
     *  inverseJoinColumns={@ORM\JoinColumn(onDelete="CASCADE")}
     * )
     *
     **/
    private $students;


    /**
     * Constructor
     */
    public function __construct()
    {

        $this->students = new ArrayCollection();
        $this->assignments = new ArrayCollection();

    }

    /**
     * @var integer
     * @Expose
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @Expose
     *
     * @ORM\Column(name="courseName", type="string", length=50)
     */
    private $courseName;

    /**
     * @var string
     * @Expose
     *
     * @ORM\Column(name="courseCode", type="string", length=10, nullable=true)
     */
    private $courseCode;

    /**
     * @var string
     * @Expose
     *
     * @ORM\Column(name="instructorName", type="string", length=50)
     */
    private $instructorName;


    /**
     * @var string
     * @Expose
     *
     * @ORM\Column(name="userId", type="integer", length=11)
     */
    private $userId;



    /**
     * @var boolean
     * @Expose
     *
     * @ORM\Column(name="archived", type="boolean", nullable=true)
     */
    private $archived;


    /**
     * @var integer
     * @Expose
     *
     * @ORM\Column(name="createdAt", type="integer", length=255)
     */
    private $createdAt;

    /**
     * @var integer
     * @Expose
     *
     * @ORM\Column(name="lastUpdated", type="integer", length=255, nullable=true)
     */
    private $lastUpdated;

    /**
     * @var integer
     * @Expose
     *
     * @ORM\Column(name="lastModified", type="integer", length=255)
     */
    private $lastModified;

    /* Remove after big migrations */
    /**
     * @var string
     *
     *
     * @ORM\Column(name="deviceIds", type="text", nullable=true)
     */
    private $deviceIds;

    /**
     * @Expose
     */
    public $studentList;

    /**
     * @Expose
     */
    public $assignmentList;



    /**
     * Get deviceIds
     *
     * @return string
     */
    public function getDeviceIds()
    {
        return $this->deviceIds;
    }




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
     * @ORM\PostLoad
     */
    public function loadEntityList(){
//        $studentIds = [];
//        foreach($this->students as $student){
//            $studentIds[] = $student->getId();
//        }
//        $this->studentList = array_values($studentIds);
//
//        $assignmentIds = [];
//        foreach($this->assignments as $assignment){
//            $assignmentIds[] = $assignment->getId();
//        }
//        $this->assignmentList = array_values($assignmentIds);
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
     * @return Course
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
     * Set userId
     *
     * @param integer $userId
     * @return Course
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return integer
     */
    public function getUserId()
    {
        return $this->userId;
    }




    /**
     * Set instructorName
     *
     * @param string $instructorName
     * @return Course
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
     * @return Course
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
     * @return Course
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
     * @return Course
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
     * @return Course
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
     * Set courseCode
     *
     * @param string $courseCode
     * @return Course
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
     * Add assignment
     *
     * @param \Whatsdue\MainBundle\Entity\Assignment $assignment
     *
     * @return Course
     */
    public function addAssignment(Assignment $assignment)
    {
        $this->assignments[] = $assignment;

        return $this;
    }

    /**
     * Remove assignment
     *
     * @param \Whatsdue\MainBundle\Entity\Assignment $assignment
     */
    public function removeAssignment(Assignment $assignment)
    {
        $this->assignments->removeElement($assignment);
    }

    /**
     * Get assignments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAssignments()
    {
        return $this->assignments;
    }


    /**
     * Add student
     *
     * @param \Whatsdue\MainBundle\Entity\Student $student
     *
     * @return Course
     */
    public function addStudent(Student $student)
    {

        if (!$this->students->contains($student)) {
            $this->students[] = $student;
        }

        return $this;
    }

    /**
     * Remove student
     *
     * @param \Whatsdue\MainBundle\Entity\Student $student
     */
    public function removeStudent(Student $student)
    {
        $this->students->removeElement($student);
    }

    /**
     * Get students
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getStudents()
    {
        return $this->students;
    }

    /**
     * Set deviceIds
     *
     * @param string $deviceIds
     *
     * @return Course
     */
    public function setDeviceIds($deviceIds)
    {
        $this->deviceIds = $deviceIds;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Whatsdue\MainBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set user
     *
     * @param \Whatsdue\MainBundle\Entity\User $user
     *
     * @return Course
     */
    public function setUser(User $user = null)
    {
        $this->user = $user;

        return $this;
    }
}

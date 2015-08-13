<?php
/**
 * Created by PhpStorm.
 * User: dan
 * Date: 2014-04-16
 * Time: 2:32 PM
 */

namespace Whatsdue\MainBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Whatsdue\MainBundle\Entity\Course;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;


/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 * @ExclusionPolicy("all")
 */

/*
 * Note: email is set to username in lifecycle actions
 */

class User extends BaseUser
{



    /**
     * @ORM\OneToMany(targetEntity="Course", mappedBy="user", fetch="EXTRA_LAZY", cascade={"all"})
     **/
    private $courses;

    public function __construct()
    {
        parent::__construct();
        $this->courses = new ArrayCollection();

    }



    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @Expose
     */
    protected $id;


    /**
     * @ORM\Column(name="signup_date", type="string", nullable=true)
     * @Expose
     */
    protected $signupDate;

    /**
     * @ORM\Column(name="settings", type="string", nullable=true)
     * @Expose
     */
    protected $settings;

    /**
     * @ORM\Column(name="salutation", type="string")
     * @Expose
     */
    protected $salutation;

    /**
     * @ORM\Column(name="first_name", type="string")
     * @Expose
     */
    protected $firstName;

    /**
     * @ORM\Column(name="last_name", type="string")
     * @Expose
     */
    protected $lastName;

    /**
     * @ORM\Column(name="institution_name", type="string")
     * @Expose
     */
    protected $institutionName;

    /**
     * @Expose
     */
    public $uniqueStudents;

    /**
     * @Expose
     */
    public $uniqueInvitations;

    /**
     * @Expose
     */
    public $totalCourses;

    /**
     * @Expose
     */
    public $totalAssignments;



    /**
     * Set Signup Date
     *
     * @param string $signupDate
     * @return User
     */
    public function setSignupDate($signupDate)
    {
        $this->signupDate = $signupDate;

        return $this;
    }

    /**
     * Get Signup Dates
     *
     * @return string
     */
    public function getSignupDate()
    {
        return $this->signupDate;
    }

    /**
     * Set settings
     *
     * @param string $settings
     * @return User
     */
    public function setSettings($settings)
    {
        $this->settings = $settings;

        return $this;
    }

    /**
     * Get settings
     *
     * @return string
     */
    public function getSettings()
    {
        return $this->settings;
    }

    /**
     * Set salutation
     *
     * @param string $salutation
     * @return User
     */
    public function setSalutation($salutation)
    {
        $this->salutation = $salutation;

        return $this;
    }

    /**
     * Get salutation
     *
     * @return string
     */
    public function getSalutation()
    {
        return $this->salutation;
    }


    /**
     * Set First Name
     *
     * @param string $firstName
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set Last Name
     *
     * @param string $lastName
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get Last Name
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set Institution Name
     *
     * @param string $institutionName
     * @return User
     */
    public function setInstitutionName($institutionName)
    {
        $this->institutionName = $institutionName;

        return $this;
    }

    /**
     * Get Institution Name
     *
     * @return string
     */
    public function getInstitutionName()
    {
        return $this->institutionName;
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
     * Set uniqueFollowers
     *
     * @param integer $uniqueFollowers
     *
     * @return User
     */
    public function setUniqueFollowers($uniqueFollowers)
    {
        $this->uniqueFollowers = $uniqueFollowers;

        return $this;
    }

    /**
     * Get uniqueFollowers
     *
     * @return integer
     */
    public function getUniqueFollowers()
    {
        return $this->uniqueFollowers;
    }

    /**
     * Set uniqueInvitations
     *
     * @param integer $uniqueInvitations
     *
     * @return User
     */
    public function setUniqueInvitations($uniqueInvitations)
    {
        $this->uniqueInvitations = $uniqueInvitations;

        return $this;
    }

    /**
     * Get uniqueInvitations
     *
     * @return integer
     */
    public function getUniqueInvitations()
    {
        return $this->uniqueInvitations;
    }

    /**
     * Set totalCourses
     *
     * @param integer $totalCourses
     *
     * @return User
     */
    public function setTotalCourses($totalCourses)
    {
        $this->totalCourses = $totalCourses;

        return $this;
    }

    /**
     * Get totalCourses
     *
     * @return integer
     */
    public function getTotalCourses()
    {
        return $this->totalCourses;
    }

    /**
     * Set totalAssignments
     *
     * @param integer $totalAssignments
     *
     * @return User
     */
    public function setTotalAssignments($totalAssignments)
    {
        $this->totalAssignments = $totalAssignments;

        return $this;
    }

    /**
     * Get totalAssignments
     *
     * @return integer
     */
    public function getTotalAssignments()
    {
        return $this->totalAssignments;
    }

    public function cleanObject(){
    }

    /**
     * Add course
     *
     * @param \Whatsdue\MainBundle\Entity\Course $course
     *
     * @return User
     */
    public function addCourse(Course $course)
    {
        $this->courses[] = $course;

        return $this;
    }

    /**
     * Remove course
     *
     * @param \Whatsdue\MainBundle\Entity\Course $course
     */
    public function removeCourse(Course $course)
    {
        $this->courses->removeElement($course);
    }

    /**
     * Get courses
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCourses()
    {
        return $this->courses;
    }
}

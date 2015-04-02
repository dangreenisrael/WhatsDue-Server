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


/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */

/*
 * Note: email is set to username in lifecycle actions
 */

class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;


    /** @ORM\Column(name="settings", type="string", nullable=true) */
    protected $settings;

    /** @ORM\Column(name="salutation", type="string") */
    protected $salutation;

    /** @ORM\Column(name="first_name", type="string") */
    protected $firstName;

    /** @ORM\Column(name="last_name", type="string") */
    protected $lastName;

    /** @ORM\Column(name="institution_name", type="string") */
    protected $institutionName;

    /** @ORM\Column(name="institution_abbreviation", type="string", nullable=true) */
    protected $institutionAbbreviation;



	public function __construct()
	{
		parent::__construct();
		// your own logic
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
     * Set Institution Abbreviation
     *
     * @param string $institutionAbbreviation
     * @return User
     */
    public function setInstitutionAbbreviation($institutionAbbreviation)
    {
        $this->institutionAbbreviation = $institutionAbbreviation;

        return $this;
    }

    /**
     * Get Institution Abbreviation
     *
     * @return string
     */
    public function getInstitutionAbbreviation()
    {
        return $this->institutionAbbreviation;
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
}

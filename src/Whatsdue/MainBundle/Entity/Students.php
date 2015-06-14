<?php

namespace Whatsdue\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Students
 *
 * @ORM\Table(name="Devices")
 * @ORM\Entity(repositoryClass="Whatsdue\MainBundle\Entity\StudentsRepository")
 */
class Students
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
     * @ORM\Column(name="uuid", type="string", length=255)
     */
    private $uuid;


    /**
     * @var string
     *
     * @ORM\Column(name="platform", type="string", length=255)
     */
    private $platform;

    /**
     * @var string
     *
     * @ORM\Column(name="pushId", type="string", length=255)
     */
    private $pushId;


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
     * Set uuid
     *
     * @param string $uuid
     * @return Students
     */
    public function setUuid($uuid)
    {
        $this->uuid = $uuid;

        return $this;
    }

    /**
     * Get uuid
     *
     * @return string 
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * Set platform
     *
     * @param string $platform
     * @return Students
     */
    public function setPlatform($platform)
    {
        $this->platform = $platform;

        return $this;
    }

    /**
     * Get platform
     *
     * @return string 
     */
    public function getPlatform()
    {
        return $this->platform;
    }

    /**
     * Set pushId
     *
     * @param string $pushId
     * @return Students
     */
    public function setPushId($pushId)
    {
        $this->pushId = $pushId;

        return $this;
    }

    /**
     * Get pushId
     *
     * @return string 
     */
    public function getPushId()
    {
        return $this->pushId;
    }

}

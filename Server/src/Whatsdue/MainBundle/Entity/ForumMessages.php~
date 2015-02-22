<?php

namespace Whatsdue\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Messages
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Whatsdue\MainBundle\Entity\ForumMessagesRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class ForumMessages
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
     * @ORM\Column(name="user_id", type="string", length=255)
     */
    private $userId;

    /**
     * @var integer
     *
     * @ORM\Column(name="reference_id", type="integer")
     */
    private $referenceId;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="body", type="string", length=255)
     */
    private $body;

    /**
     * @var string
     *
     * @ORM\Column(name="createdAt", type="string", length=255)
     */
    private $createdAt;

    /**
     * @var string
     *
     * @ORM\Column(name="updatedAt", type="string", length=255)
     */
    private $updatedAt;


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
     * Set userId
     *
     * @param string $userId
     * @return Messages
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return string 
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set referenceId
     *
     * @param integer $referenceId
     * @return Messages
     */
    public function setReferenceId($referenceId)
    {
        $this->referenceId = $referenceId;

        return $this;
    }

    /**
     * Get referenceId
     *
     * @return integer 
     */
    public function getReferenceId()
    {
        return $this->referenceId;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Messages
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set body
     *
     * @param string $body
     * @return Messages
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get body
     *
     * @return string 
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set createdAt
     *
     * @param string $createdAt
     * @return Messages
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return string 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param string $updatedAt
     * @return Messages
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return string 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
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
        $this->updatedAt = $this->timestamp();
    }


    /**
     * @ORM\PreUpdate
     */
    public function setLastUpdatedValue()
    {
        $this->updatedAt = $this->timestamp();

    }
}

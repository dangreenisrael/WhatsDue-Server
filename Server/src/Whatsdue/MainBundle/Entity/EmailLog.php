<?php

namespace Whatsdue\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Email
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Whatsdue\MainBundle\Entity\EmailLogRepository")
 */
class EmailLog
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
     * @ORM\Column(name="user", type="string", length=255)
     */
    private $user;

    /**
     * @var string
     *
     * @ORM\Column(name="recipients", type="text")
     */
    private $recipients;

    /**
     * @var integer
     *
     * @ORM\Column(name="recipient_count", type="integer", nullable=true)
     */
    private $recipientCount;


    /**
     * @var string
     *
     * @ORM\Column(name="subject", type="string", length=255)
     */
    private $subject;

    /**
     * @var string
     *
     * @ORM\Column(name="body", type="text")
     */
    private $body;

    /**
     * @var string
     *
     * @ORM\Column(name="tag", type="string", length=255)
     */
    private $tag;

    /**
     * @var string
     *
     * @ORM\Column(name="meta", type="text", nullable=true)
     */
    private $meta;

    /**
     * @var integer
     *
     * @ORM\Column(name="date", type="string", length=255)
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="delivered", type="text", nullable=true)
     */
    private $delivered;

    /**
     * @var string
     *
     * @ORM\Column(name="opened", type="text", nullable=true)
     */
    private $opened;

    /**
     * @var string
     *
     * @ORM\Column(name="converted", type="text", nullable=true)
     */
    private $converted;

    /**
     * @var string
     *
     * @ORM\Column(name="failed", type="text", nullable=true)
     */
    private $failed;


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
     * Set user
     *
     * @param string $user
     * @return EmailLog
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return string 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set recipients
     *
     * @param string $recipients
     * @return EmailLog
     */
    public function setRecipients($recipients)
    {
        $this->recipients = $recipients;

        return $this;
    }

    /**
     * Get recipients
     *
     * @return string
     */
    public function getRecipients()
    {
        return $this->recipients;
    }

    /**
     * Set recipient count
     *
     * @param string $recipientCount
     * @return EmailLog
     */
    public function setRecipientCount($recipientCount)
    {
        $this->recipientCount = $recipientCount;

        return $this;
    }

    /**
     * Get recipient count
     *
     * @return string 
     */
    public function getRecipientCount()
    {
        return $this->recipientCount;
    }





    /**
     * Set subject
     *
     * @param string $subject
     * @return EmailLog
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return string 
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set body
     *
     * @param string $body
     * @return EmailLog
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
     * Set tag
     *
     * @param string $tag
     * @return EmailLog
     */
    public function setTag($tag)
    {
        $this->tag = $tag;

        return $this;
    }

    /**
     * Get tag
     *
     * @return string
     */
    public function getTag()
    {
        return $this->tag;
    }


    /**
     * Set Meta
     *
     * @param string $meta
     * @return EmailLog
     */
    public function setMeta($meta)
    {
        $this->meta = $meta;

        return $this;
    }

    /**
     * Get meta
     *
     * @return string
     */
    public function getMeta()
    {
        return $this->meta;
    }


    /**
     * Set date
     *
     * @param integer $date
     * @return EmailLog
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return integer
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set delivered
     *
     * @param string $delivered
     * @return EmailLog
     */
    public function setDelivered($delivered)
    {
        $this->delivered = $delivered;

        return $this;
    }

    /**
     * Get delivered
     *
     * @return string 
     */
    public function getDelivered()
    {
        return $this->delivered;
    }

    /**
     * Set opened
     *
     * @param string $opened
     * @return EmailLog
     */
    public function setOpened($opened)
    {
        $this->opened = $opened;

        return $this;
    }

    /**
     * Get opened
     *
     * @return string 
     */
    public function getOpened()
    {
        return $this->opened;
    }

    /**
     * Set converted
     *
     * @param string $converted
     * @return EmailLog
     */
    public function setConverted($converted)
    {
        $this->converted = $converted;

        return $this;
    }

    /**
     * Get converted
     *
     * @return string 
     */
    public function getConverted()
    {
        return $this->converted;
    }

    /**
     * Set failed
     *
     * @param string $failed
     * @return EmailLog
     */
    public function setFailed($failed)
    {
        $this->failed = $failed;

        return $this;
    }

    /**
     * Get failed
     *
     * @return string 
     */
    public function getFailed()
    {
        return $this->failed;
    }
}

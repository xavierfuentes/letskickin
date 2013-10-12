<?php

namespace letskickin\BackBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Security\Core\Util\SecureRandom;

use letskickin\BackBundle\Entity\Pot;

/**
 * @ORM\Entity()
 * @ORM\Table(name="lk_participant")
 */
class Participant
{
	/**
     * @var integer $id
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

	/**
	 * @var string $status
	 *
	 * @ORM\Column(type="integer", name="participant_status")
	 */
	private $status;

	/**
     * @ORM\ManyToOne(targetEntity="letskickin\BackBundle\Entity\Pot", inversedBy="participants", cascade={"persist"})
     */
    protected $pot;

	/**
	 * @var string $participant_key
	 *
	 * @ORM\Column(type="string", unique=true, length=32)
	 */
	private $participant_key;

	/**
     * @var \DateTime $date
     *
     * @ORM\Column(type="datetime")
     */
    protected $date;

	/**
     * @var string $name
     *
     * @ORM\Column(type="string")
     */
    private $name;

	/**
	 * @var integer $amount
	 *
	 * @ORM\Column(type="integer")
	 */
	private $amount;

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
     * Set participant_key
     *
     * @param string $participantKey
     * @return Participant
     */
    public function setParticipantKey($participantKey)
    {
        $this->participant_key = $participantKey;
    
        return $this;
    }

    /**
     * Get participant_key
     *
     * @return string 
     */
    public function getParticipantKey()
    {
        return $this->participant_key;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Participant
     */
    public function setDate($date)
    {
        $this->date = $date;
    
        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Participant
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return Participant
     */
    public function setStatus($status)
    {
        $this->status = $status;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return integer 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set pot
     *
     * @param \letskickin\BackBundle\Entity\Pot $pot
     * @return Participant
     */
    public function setPot(\letskickin\BackBundle\Entity\Pot $pot = null)
    {
        $this->pot = $pot;
    
        return $this;
    }

    /**
     * Get pot
     *
     * @return \letskickin\BackBundle\Entity\Pot 
     */
    public function getPot()
    {
        return $this->pot;
    }

    /**
     * Set amount
     *
     * @param integer $amount
     * @return Participant
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    
        return $this;
    }

    /**
     * Get amount
     *
     * @return integer 
     */
    public function getAmount()
    {
        return $this->amount;
    }
}
<?php

namespace letskickin\BackBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Security\Core\Util\SecureRandom;

use letskickin\BackBundle\Entity\Pot;

/**
 * @ORM\Entity()
 * @ORM\Table(name="participant")
 */
class Participant
{
	const STATUS_NO_PARTICIPATES = 0;
	const STATUS_WAITING = 1;
	const STATUS_CONTRIBUTED = 2;
	const STATUS_CONFIRMED = 3;

    /**
     * @var integer $id
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="letskickin\BackBundle\Entity\Pot", inversedBy="participants", cascade={"persist"})
     */
    protected $pot;

	/**
	 * @var string $key
	 *
	 * @ORM\Column(type="string", name="participant_key")
	 */
	private $key;

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
	 * @var string $concept
	 *
	 * @ORM\Column(type="string", nullable=true)
	 */
	private $concept;

	/**
	 * @var string $status
	 *
	 * @ORM\Column(type="integer", name="participant_status")
	 */
	private $status;

	/**
	 * @var string $email
	 *
	 * @ORM\Column(type="string")
	 */
	private $email;

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
     * Set key
     *
     * @param string $key
     * @return Participant
     */
    public function setKey($key)
    {
        $this->key = $key;
    
        return $this;
    }

    /**
     * Get key
     *
     * @return string 
     */
    public function getKey()
    {
        return $this->key;
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
     * Set concept
     *
     * @param string $concept
     * @return Participant
     */
    public function setConcept($concept)
    {
        $this->concept = $concept;
    
        return $this;
    }

    /**
     * Get concept
     *
     * @return string 
     */
    public function getConcept()
    {
        return $this->concept;
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
     * Set email
     *
     * @param string $email
     * @return Participant
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
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
}
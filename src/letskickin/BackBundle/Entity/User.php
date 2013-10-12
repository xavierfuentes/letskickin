<?php

namespace letskickin\BackBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="lk_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

	/**
	 * @ORM\OneToMany(targetEntity="letskickin\BackBundle\Entity\Pot", mappedBy="owner", cascade={"persist", "remove"})
	 */
	private $pots;

	/**
	 * @var string $pot_key
	 *
	 * @ORM\Column(type="string", unique=true, length=32)
	 */
	private $user_key;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $firstname;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $lastname;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=10)
     */
    protected $gender;

    /**
     * @var date $birthday
     *
     * @ORM\Column(type="date", nullable=true)
     */
    protected $birthday;

	/**
     * @var boolean
     *
     * @ORM\Column(type="boolean")
     */
    protected $terms;

	/**
	 * @var boolean
	 *
	 * @ORM\Column(type="boolean")
	 */
	protected $subscription;

	/** @ORM\Column(name="facebook_id", type="string", length=255, nullable=true) */
    protected $facebook_id;

    /** @ORM\Column(name="facebook_access_token", type="string", length=255, nullable=true) */
    protected $facebook_access_token;

    // Here can go some other OAuth providers

	/**
	 * Constructor
	 */
	public function __construct()
    {
        parent::__construct();
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
     * Set user_key
     *
     * @param string $userKey
     * @return User
     */
    public function setUserKey($userKey)
    {
        $this->user_key = $userKey;
    
        return $this;
    }

    /**
     * Get user_key
     *
     * @return string 
     */
    public function getUserKey()
    {
        return $this->user_key;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     * @return User
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    
        return $this;
    }

    /**
     * Get firstname
     *
     * @return string 
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     * @return User
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    
        return $this;
    }

    /**
     * Get lastname
     *
     * @return string 
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set gender
     *
     * @param string $gender
     * @return User
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    
        return $this;
    }

    /**
     * Get gender
     *
     * @return string 
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set birthday
     *
     * @param \DateTime $birthday
     * @return User
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;
    
        return $this;
    }

    /**
     * Get birthday
     *
     * @return \DateTime 
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * Set terms
     *
     * @param boolean $terms
     * @return User
     */
    public function setTerms($terms)
    {
        $this->terms = $terms;
    
        return $this;
    }

    /**
     * Get terms
     *
     * @return boolean 
     */
    public function getTerms()
    {
        return $this->terms;
    }

    /**
     * Set subscription
     *
     * @param boolean $subscription
     * @return User
     */
    public function setSubscription($subscription)
    {
        $this->subscription = $subscription;
    
        return $this;
    }

    /**
     * Get subscription
     *
     * @return boolean 
     */
    public function getSubscription()
    {
        return $this->subscription;
    }

    /**
     * Set facebook_id
     *
     * @param string $facebookId
     * @return User
     */
    public function setFacebookId($facebookId)
    {
        $this->facebook_id = $facebookId;
    
        return $this;
    }

    /**
     * Get facebook_id
     *
     * @return string 
     */
    public function getFacebookId()
    {
        return $this->facebook_id;
    }

    /**
     * Set facebook_access_token
     *
     * @param string $facebookAccessToken
     * @return User
     */
    public function setFacebookAccessToken($facebookAccessToken)
    {
        $this->facebook_access_token = $facebookAccessToken;
    
        return $this;
    }

    /**
     * Get facebook_access_token
     *
     * @return string 
     */
    public function getFacebookAccessToken()
    {
        return $this->facebook_access_token;
    }

    /**
     * Add pots
     *
     * @param \letskickin\BackBundle\Entity\Pot $pots
     * @return User
     */
    public function addPot(\letskickin\BackBundle\Entity\Pot $pots)
    {
        $this->pots[] = $pots;
    
        return $this;
    }

    /**
     * Remove pots
     *
     * @param \letskickin\BackBundle\Entity\Pot $pots
     */
    public function removePot(\letskickin\BackBundle\Entity\Pot $pots)
    {
        $this->pots->removeElement($pots);
    }

    /**
     * Get pots
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPots()
    {
        return $this->pots;
    }
}
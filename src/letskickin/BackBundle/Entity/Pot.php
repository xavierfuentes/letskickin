<?php

namespace letskickin\BackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="lk_pot")
 */
class Pot
{
    /**
     * @var integer $id
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer $status
     *
     * @ORM\Column(type="integer")
     */
    private $status;

    /**
     * @var \DateTime $date
     *
     * @ORM\Column(type="datetime")
     */
    private $creation_date;

    /**
     * @var string $pot_key
     *
     * @ORM\Column(type="string", unique=true, length=16)
     */
    private $pot_key;

    /**
     * @var string $occasion
     *
     * @ORM\Column(type="string", length=140)
     */
    private $occasion;

	/**
	 * @ORM\ManyToOne(targetEntity="letskickin\BackBundle\Entity\User", inversedBy="pots", cascade={"persist", "remove"})
	 */
	private $owner;

    /**
     * @var string $admin_key
     *
     * @ORM\Column(type="string", length=8)
     */
    private $admin_key;

    /**
     * @var string $admin_name
     *
     * @ORM\Column(type="string")
     */
    private $admin_name;

    /**
     * @var string $admin_email
     *
     * @ORM\Column(type="string", length=60)
     */
    private $admin_email;

    /**
     * @var \DateTime $deadline
     *
     * @ORM\Column(type="datetime")
     */
    private $deadline;

    /**
     * @var string $currency
     *
     * @ORM\Column(type="string", length=3)
     */
    private $currency;

    /**
     * @var integer $amount_total
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $amount_total;

    /**
     * @var integer $amount_partial
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $amount_partial;

    /**
     * @var integer $bank_account
     *
     * @ORM\Column(type="string", length=30)
     */
    private $bank_account;

    /**
     * @var integer $collection_method
     *
     * @ORM\Column(type="integer")
     */
    private $collection_method;

    /**
     * @ORM\OneToMany(targetEntity="letskickin\BackBundle\Entity\Participant", mappedBy="pot", cascade={"persist", "remove"})
     */
    private $participants;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->participants = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set status
     *
     * @param integer $status
     * @return Pot
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
     * Set creation_date
     *
     * @param \DateTime $creationDate
     * @return Pot
     */
    public function setCreationDate($creationDate)
    {
        $this->creation_date = $creationDate;
    
        return $this;
    }

    /**
     * Get creation_date
     *
     * @return \DateTime 
     */
    public function getCreationDate()
    {
        return $this->creation_date;
    }

    /**
     * Set pot_key
     *
     * @param string $potKey
     * @return Pot
     */
    public function setPotKey($potKey)
    {
        $this->pot_key = $potKey;
    
        return $this;
    }

    /**
     * Get pot_key
     *
     * @return string 
     */
    public function getPotKey()
    {
        return $this->pot_key;
    }

    /**
     * Set occasion
     *
     * @param string $occasion
     * @return Pot
     */
    public function setOccasion($occasion)
    {
        $this->occasion = $occasion;
    
        return $this;
    }

    /**
     * Get occasion
     *
     * @return string 
     */
    public function getOccasion()
    {
        return $this->occasion;
    }

    /**
     * Set admin_key
     *
     * @param string $adminKey
     * @return Pot
     */
    public function setAdminKey($adminKey)
    {
        $this->admin_key = $adminKey;
    
        return $this;
    }

    /**
     * Get admin_key
     *
     * @return string 
     */
    public function getAdminKey()
    {
        return $this->admin_key;
    }

    /**
     * Set admin_name
     *
     * @param string $adminName
     * @return Pot
     */
    public function setAdminName($adminName)
    {
        $this->admin_name = $adminName;
    
        return $this;
    }

    /**
     * Get admin_name
     *
     * @return string 
     */
    public function getAdminName()
    {
        return $this->admin_name;
    }

    /**
     * Set admin_email
     *
     * @param string $adminEmail
     * @return Pot
     */
    public function setAdminEmail($adminEmail)
    {
        $this->admin_email = $adminEmail;
    
        return $this;
    }

    /**
     * Get admin_email
     *
     * @return string 
     */
    public function getAdminEmail()
    {
        return $this->admin_email;
    }

    /**
     * Set deadline
     *
     * @param \DateTime $deadline
     * @return Pot
     */
    public function setDeadline($deadline)
    {
        $this->deadline = $deadline;
    
        return $this;
    }

    /**
     * Get deadline
     *
     * @return \DateTime 
     */
    public function getDeadline()
    {
        return $this->deadline;
    }

    /**
     * Set currency
     *
     * @param string $currency
     * @return Pot
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
    
        return $this;
    }

    /**
     * Get currency
     *
     * @return string 
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Set amount_total
     *
     * @param integer $amountTotal
     * @return Pot
     */
    public function setAmountTotal($amountTotal)
    {
        $this->amount_total = $amountTotal;
    
        return $this;
    }

    /**
     * Get amount_total
     *
     * @return integer 
     */
    public function getAmountTotal()
    {
        return $this->amount_total;
    }

    /**
     * Set amount_partial
     *
     * @param integer $amountPartial
     * @return Pot
     */
    public function setAmountPartial($amountPartial)
    {
        $this->amount_partial = $amountPartial;
    
        return $this;
    }

    /**
     * Get amount_partial
     *
     * @return integer 
     */
    public function getAmountPartial()
    {
        return $this->amount_partial;
    }

    /**
     * Set bank_account
     *
     * @param string $bankAccount
     * @return Pot
     */
    public function setBankAccount($bankAccount)
    {
        $this->bank_account = $bankAccount;
    
        return $this;
    }

    /**
     * Get bank_account
     *
     * @return string 
     */
    public function getBankAccount()
    {
        return $this->bank_account;
    }

    /**
     * Set collection_method
     *
     * @param integer $collectionMethod
     * @return Pot
     */
    public function setCollectionMethod($collectionMethod)
    {
        $this->collection_method = $collectionMethod;
    
        return $this;
    }

    /**
     * Get collection_method
     *
     * @return integer 
     */
    public function getCollectionMethod()
    {
        return $this->collection_method;
    }

    /**
     * Set owner
     *
     * @param \letskickin\BackBundle\Entity\User $owner
     * @return Pot
     */
    public function setOwner(\letskickin\BackBundle\Entity\User $owner = null)
    {
        $this->owner = $owner;
    
        return $this;
    }

    /**
     * Get owner
     *
     * @return \letskickin\BackBundle\Entity\User 
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Add participants
     *
     * @param \letskickin\BackBundle\Entity\Participant $participants
     * @return Pot
     */
    public function addParticipant(\letskickin\BackBundle\Entity\Participant $participants)
    {
        $this->participants[] = $participants;
    
        return $this;
    }

    /**
     * Remove participants
     *
     * @param \letskickin\BackBundle\Entity\Participant $participants
     */
    public function removeParticipant(\letskickin\BackBundle\Entity\Participant $participants)
    {
        $this->participants->removeElement($participants);
    }

    /**
     * Get participants
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getParticipants()
    {
        return $this->participants;
    }
}
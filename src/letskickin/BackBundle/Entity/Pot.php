<?php

namespace letskickin\BackBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="pot")
 */
class Pot
{
    // Created but not finished
    const INACTIVE = 0;
    // Created and valid
    const ACTIVE = 1;

    // Bank transfer
    const TRANSFER = 0;

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
     * @var string $pot_id
     *
     * @ORM\Column(type="string", unique=true)
     */
    private $pot_id;

    /**
     * @var string $occasion
     *
     * @ORM\Column(type="string")
     */
    private $occasion;

    /**
     * @var string $user_id
     *
     * @ORM\Column(type="string")
     */
    private $user_id;

    /**
     * @var string $user_name
     *
     * @ORM\Column(type="string")
     */
    private $user_name;

    /**
     * @var string $user_email
     *
     * @ORM\Column(type="string")
     */
    private $user_email;

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
     * @ORM\Column(type="integer")
     */
    private $amount_total;

    /**
     * @var integer $amount_partial
     *
     * @ORM\Column(type="integer")
     */
    private $amount_partial;

    /**
     * @var integer $bank_account
     *
     * @ORM\Column(type="integer")
     */
    private $bank_account;

    /**
     * @var integer $collection_method
     *
     * @ORM\Column(type="integer")
     */
    private $collection_method;

    /**
     * @ORM\OneToMany(targetEntity="letskickin\BackBundle\Entity\Guest", mappedBy="pot", cascade={"persist"})
     */
    private $guests;

    /**
     * @var string $message
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $message;

    /**
     * @var boolean $tracking_active
     *
     * @ORM\Column(type="boolean")
     */
    private $tracking_active;

    /**
     * @var boolean $notifications_active
     *
     * @ORM\Column(type="boolean")
     */
    private $notifications_active;

    /**
     * @var boolean $guests_invite
     *
     * @ORM\Column(type="boolean")
     */
    private $guests_invite;

    /**
     * @var boolean $reminders_active
     *
     * @ORM\Column(type="boolean")
     */
    private $reminders_active;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->guests = new ArrayCollection();
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
     * Set pot_id
     *
     * @param string $potId
     * @return Pot
     */
    public function setPotId($potId)
    {
        $this->pot_id = $potId;

        return $this;
    }

    /**
     * Get pot_id
     *
     * @return string
     */
    public function getPotId()
    {
        return $this->pot_id;
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
     * Set user_id
     *
     * @param string $userId
     * @return Pot
     */
    public function setUserId($userId)
    {
        $this->user_id = $userId;

        return $this;
    }

    /**
     * Get user_id
     *
     * @return string
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * Set user_name
     *
     * @param string $userName
     * @return Pot
     */
    public function setUserName($userName)
    {
        $this->user_name = $userName;

        return $this;
    }

    /**
     * Get user_name
     *
     * @return string
     */
    public function getUserName()
    {
        return $this->user_name;
    }

    /**
     * Set user_email
     *
     * @param string $userEmail
     * @return Pot
     */
    public function setUserEmail($userEmail)
    {
        $this->user_email = $userEmail;

        return $this;
    }

    /**
     * Get user_email
     *
     * @return string
     */
    public function getUserEmail()
    {
        return $this->user_email;
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
     * @param integer $bankAccount
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
     * @return integer
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
     * Set message
     *
     * @param string $message
     * @return Pot
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set tracking_active
     *
     * @param boolean $trackingActive
     * @return Pot
     */
    public function setTrackingActive($trackingActive)
    {
        $this->tracking_active = $trackingActive;

        return $this;
    }

    /**
     * Get tracking_active
     *
     * @return boolean
     */
    public function getTrackingActive()
    {
        return $this->tracking_active;
    }

    /**
     * Set notifications_active
     *
     * @param boolean $notificationsActive
     * @return Pot
     */
    public function setNotificationsActive($notificationsActive)
    {
        $this->notifications_active = $notificationsActive;

        return $this;
    }

    /**
     * Get notifications_active
     *
     * @return boolean
     */
    public function getNotificationsActive()
    {
        return $this->notifications_active;
    }

    /**
     * Set guests_invite
     *
     * @param boolean $guestsInvite
     * @return Pot
     */
    public function setGuestsInvite($guestsInvite)
    {
        $this->guests_invite = $guestsInvite;

        return $this;
    }

    /**
     * Get guests_invite
     *
     * @return boolean
     */
    public function getGuestsInvite()
    {
        return $this->guests_invite;
    }

    /**
     * Set reminders_active
     *
     * @param boolean $remindersActive
     * @return Pot
     */
    public function setRemindersActive($remindersActive)
    {
        $this->reminders_active = $remindersActive;

        return $this;
    }

    /**
     * Get reminders_active
     *
     * @return boolean
     */
    public function getRemindersActive()
    {
        return $this->reminders_active;
    }

    /**
     * Add guests
     *
     * @param \letskickin\BackBundle\Entity\Guest $guests
     * @return Pot
     */
    public function addGuest(Guest $guests)
    {
        $this->guests[] = $guests;

        return $this;
    }

    /**
     * Remove guests
     *
     * @param \letskickin\BackBundle\Entity\Guest $guests
     */
    public function removeGuest(Guest $guests)
    {
        $this->guests->removeElement($guests);
    }

    /**
     * Get guests
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGuests()
    {
        return $this->guests;
    }
}
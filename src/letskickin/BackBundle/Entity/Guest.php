<?php

namespace letskickin\BackBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

use letskickin\BackBundle\Entity\Pot;

/**
 * @ORM\Entity()
 * @ORM\Table(name="guest")
 */
class Guest
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
     * @ORM\ManyToOne(targetEntity="letskickin\BackBundle\Entity\Pot", inversedBy="guests", cascade={"persist", "remove"})
     */
    protected $pot;

    /**
     * @var \DateTime $date
     *
     * @ORM\Column(type="datetime")
     */
    protected $date;

    /**
     * @var string $email
     *
     * @ORM\Column(type="string")
     */
    private $email;

    /**
     * Constructor
     */
    public function __construct(Pot $pot)
    {
        $this->setPot($pot);
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
     * Set date
     *
     * @param \DateTime $date
     * @return Guest
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
     * Set email
     *
     * @param string $email
     * @return Guest
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
     * @return Guest
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
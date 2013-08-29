<?php

namespace letskickin\BackBundle\Event;

use Symfony\Component\EventDispatcher\Event;

use letskickin\BackBundle\Entity\Guest;
use letskickin\BackBundle\Entity\Pot;

class GuestEvent extends Event
{
    /**
     * @var \letskickin\BackBundle\Entity\Pot
     */
    protected $pot;

    /**
     * @var \letskickin\BackBundle\Entity\Guest
     */
    protected $guest;

    public function __construct(Pot $pot, Guest $guest)
    {
        $this->guest = $guest;
        $this->pot = $pot;
    }

    /**
     * @return Pot
     */
    public function getPot()
    {
        return $this->pot;
    }

    /**
     * @return Guest
     */
    public function getGuest()
    {
        return $this->guest;
    }
}

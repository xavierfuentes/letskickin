<?php

namespace letskickin\BackBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class GuestEvent extends Event
{
    protected $pot;
    protected $guest;

    public function __construct($pot, $guest)
    {
        $this->guest = $guest;
        $this->pot = $pot;
    }
    public function getPot()
    {
        return $this->pot;
    }

    public function getGuest()
    {
        return $this->guest;
    }
}

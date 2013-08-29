<?php

namespace letskickin\BackBundle\Event;

use Symfony\Component\EventDispatcher\Event;

use letskickin\BackBundle\Entity\Pot;

class PotEvent extends Event
{
    /**
     * @var \letskickin\BackBundle\Entity\Pot
     */
    protected $pot;

    public function __construct(Pot $pot)
    {
        $this->pot = $pot;
    }

    /**
     * @return Pot
     */
    public function getPot()
    {
        return $this->pot;
    }
}

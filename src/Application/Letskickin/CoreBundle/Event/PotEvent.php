<?php

namespace Application\Letskickin\CoreBundle\Event;

use Symfony\Component\EventDispatcher\Event;

use Application\Letskickin\CoreBundle\Entity\Pot;

class PotEvent extends Event
{
    /**
     * @var \Application\Letskickin\CoreBundle\Entity\Pot
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

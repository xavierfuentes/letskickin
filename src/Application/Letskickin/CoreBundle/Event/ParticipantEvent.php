<?php

namespace Application\Letskickin\CoreBundle\Event;

use Symfony\Component\EventDispatcher\Event;

use Application\Letskickin\CoreBundle\Entity\Participant;

class ParticipantEvent extends Event
{
	/**
	 * @var \Application\Letskickin\CoreBundle\Entity\Participant
	 */
	protected $participant;

	public function __construct(Participant $participant)
	{
		$this->participant = $participant;
	}

	/**
	 * @return Participant
	 */
	public function getParticipant()
	{
		return $this->participant;
	}
}

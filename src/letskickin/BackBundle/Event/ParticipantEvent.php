<?php

namespace letskickin\BackBundle\Event;

use Symfony\Component\EventDispatcher\Event;

use letskickin\BackBundle\Entity\Participant;

class ParticipantEvent extends Event
{
	/**
	 * @var \letskickin\BackBundle\Entity\Participant
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

<?php

namespace letskickin\BackBundle;

final class ParticipantEvents
{
	/**
	 * The POT_PARTICIPANT_ADDED event occurs when a new participant is added
	 * The event listener method receives a \letskickin\BackBundle\Event\PotEvent instance
	 * @var string
	 */
	const PARTICIPANT_ADDED = 'letskickin.pot.participant_added';
}
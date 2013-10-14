<?php

namespace Application\Letskickin\CoreBundle;

final class ParticipantEvents
{
	/**
	 * The POT_PARTICIPANT_CREATED event occurs when a new participant is created (class)
	 * The event listener method receives a \letskickin\BackBundle\Event\PotEvent instance
	 * @var string
	 */
	const CREATED = 'pot.participant_created';

	/**
	 * The POT_PARTICIPANT_ADDED event occurs when a new participant is added
	 * The event listener method receives a \letskickin\BackBundle\Event\PotEvent instance
	 * @var string
	 */
	const ADDED = 'pot.participant_added';

	/**
	 * The POT_PARTICIPANT_REFUSED event occurs when a new participant refuses to contribute
	 * The event listener method receives a \letskickin\BackBundle\Event\PotEvent instance
	 * @var string
	 */
	const REFUSED = 'pot.participant_refused';

	/**
	 * The POT_PARTICIPANT_EDITED event occurs when a participant's contribution is edited
	 * The event listener method receives a \letskickin\BackBundle\Event\PotEvent instance
	 * @var string
	 */
	const UPDATED = 'pot.participant_updated';
}
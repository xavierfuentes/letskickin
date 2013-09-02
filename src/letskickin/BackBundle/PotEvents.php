<?php

namespace letskickin\BackBundle;

final class PotEvents
{
	/**
	 * The POT_SAVED event occurs when a pot is created AND is flushed into the DB
	 * The event listener method receives a \letskickin\BackBundle\Event\PotEvent instance
	 * @var string
	 */
	const POT_CREATED = 'letskickin.pot.created';

    /**
     * The POT_SAVED event occurs when a pot is created AND is flushed into the DB
     * The event listener method receives a \letskickin\BackBundle\Event\PotEvent instance
     * @var string
     */
    const POT_SAVED = 'letskickin.pot.saved';

	/**
	 * The POT_PARTICIPANT_ADDED event occurs when a new participant is added (by himself)
	 * The event listener method receives a \letskickin\BackBundle\Event\PotEvent instance
	 * @var string
	 */
	const PARTICIPANT_ADDED = 'letskickin.pot.participant_added';
}
<?php

namespace letskickin\BackBundle;

final class PotEvents
{
	/**
	 * The SAVED event occurs when a pot is created AND is flushed into the DB
	 * The event listener method receives a \letskickin\BackBundle\Event\PotEvent instance
	 * @var string
	 */
	const CREATED = 'pot.created';

    /**
     * The SAVED event occurs when a pot is created AND is flushed into the DB
     * The event listener method receives a \letskickin\BackBundle\Event\PotEvent instance
     * @var string
     */
    const FLUSHED = 'pot.flushed';

	/**
	 * The UPDATED event occurs when a pot is updated AND is flushed into the DB
	 * The event listener method receives a \letskickin\BackBundle\Event\PotEvent instance
	 * @var string
	 */
	const UPDATED = 'pot.updated';

	/**
	 * The PARTICIPANT_ADDED event occurs when a participant is added into the pot
	 * The event listener method receives a \letskickin\BackBundle\Event\PotEvent instance
	 * @var string
	 */
	const PARTICIPANT_ADDED = 'pot.participant_added';

	/**
	 * The PARTICIPANT_ADDED event occurs when a participant is added into the pot
	 * The event listener method receives a \letskickin\BackBundle\Event\PotEvent instance
	 * @var string
	 */
	const PARTICIPANT_REFUSED = 'pot.participant_refused';
}
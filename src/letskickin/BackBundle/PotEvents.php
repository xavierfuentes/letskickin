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
    const SAVED = 'pot.saved';
}
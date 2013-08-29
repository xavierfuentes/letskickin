<?php

namespace letskickin\BackBundle;

final class PotEvents
{
    /**
     * The POT_CREATED event occurs when a pot is created AND is flushed into the DB
     *
     * The event listener method
     * receives a \letskickin\BackBundle\Event\PotEvent
     * instance
     *
     * @var string
     *
     */
    const POT_CREATED = 'letskickin.pot.created';
}
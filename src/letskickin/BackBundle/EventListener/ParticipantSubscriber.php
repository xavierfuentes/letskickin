<?php

namespace letskickin\BackBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

use letskickin\BackBundle\Event\ParticipantEvent;
use letskickin\BackBundle\ParticipantEvents;

class ParticipantSubscriber implements EventSubscriberInterface
{
	private $mailer;

	public function __construct(\Swift_Mailer $mailer)
	{
		$this->mailer = $mailer;
	}

	public function onParticipantCreated(ParticipantEvent $event)
	{
		// ...
	}

	public static function getSubscribedEvents()
	{
		return array(
			ParticipantEvents::ADDED  => array('onParticipantCreated', 5),
		);
	}
}
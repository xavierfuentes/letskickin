<?php

namespace Application\Letskickin\CoreBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

use Application\Letskickin\CoreBundle\Event\ParticipantEvent;
use Application\Letskickin\CoreBundle\ParticipantEvents;

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

	public function onParticipantAdded(ParticipantEvent $event)
	{
		// ...
	}

	public function onParticipantUpdated(ParticipantEvent $event)
	{
		// ...
	}

	public function onParticipantRefused(ParticipantEvent $event)
	{
		// ...
	}

	public static function getSubscribedEvents()
	{
		return array(
			ParticipantEvents::CREATED  => array('onParticipantCreated', 5),
			ParticipantEvents::ADDED    => array('onParticipantAdded', 4),
			ParticipantEvents::UPDATED  => array('onParticipantUpdated', 3),
			ParticipantEvents::REFUSED  => array('onParticipantRefused', 2),
		);
	}
}
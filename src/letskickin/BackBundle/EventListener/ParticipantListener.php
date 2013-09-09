<?php

namespace letskickin\BackBundle\EventListener;

use Symfony\Component\HttpFoundation\Request;
use letskickin\BackBundle\Event\ParticipantEvent;

class ParticipantListener
{
	private $mailer;

	public function __construct(\Swift_Mailer $mailer)
	{
		$this->mailer = $mailer;
	}

	public function onPotCreated(ParticipantEvent $event)
	{
		$pot = $event->getParticipant()->getPot();
		$participant = $event->getParticipant();

		$message = \Swift_Message::newInstance()
			->setSubject($pot->getOccasion())
			->setFrom('send@example.com')
			->setTo($participant->getEmail())
//			->setBody(
//				$this->renderView(
//					'HelloBundle:Hello:email.txt.twig',
//					array('name' => $name)
//				)
//			)
			->setBody("Hi " . $participant->getName() . ", you have been invited to: " . $pot->getOccasion())
		;
		$this->mailer->send($message);
	}
}

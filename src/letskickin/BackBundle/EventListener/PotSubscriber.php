<?php

namespace letskickin\BackBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

use letskickin\BackBundle\Entity\Participant;
use letskickin\BackBundle\Event\PotEvent;
use letskickin\BackBundle\PotEvents;

class PotSubscriber implements EventSubscriberInterface
{
    private $mailer;

    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

	public function onPotCreated(PotEvent $event)
	{
		// ...
	}

    public function onPotSaved(PotEvent $event)
    {
        $pot = $event->getPot();

		$message = \Swift_Message::newInstance()
			->setSubject($pot->getOccasion())
			->setFrom('send@example.com')
			->setTo($pot->getAdminEmail())
//			->setBody(
//				$this->renderView(
//					'HelloBundle:Hello:email.txt.twig',
//					array('name' => $name)
//				)
//			)
			->setBody("Hi " . $pot->getAdminName() . ", you have created your pot: " . $pot->getOccasion())
		;
		$this->mailer->send($message);
    }

	public function onPotUpdated(PotEvent $event)
	{
		$pot = $event->getPot();

		$message = \Swift_Message::newInstance()
			->setSubject($pot->getOccasion())
			->setFrom('send@example.com')
			->setTo($pot->getAdminEmail())
//			->setBody(
//				$this->renderView(
//					'HelloBundle:Hello:email.txt.twig',
//					array('name' => $name)
//				)
//			)
			->setBody("Hi " . $pot->getAdminName() . ", you have edited your pot: " . $pot->getOccasion())
		;
		$this->mailer->send($message);

		// Warn all the participants
	}

    public static function getSubscribedEvents()
    {
        return array(
	        PotEvents::CREATED  => array('onPotCreated', 5),
	        PotEvents::SAVED    => array('onPotSaved', 4),
	        PotEvents::UPDATED  => array('onPotUpdated', 3),
		);
    }
}
<?php

namespace letskickin\BackBundle\EventListener;

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

use letskickin\BackBundle\Event\PotEvent;
use letskickin\BackBundle\PotEvents;

class PotSubscriber implements EventSubscriberInterface
{
    private $mailer;
	private $templating;

    public function __construct(\Swift_Mailer $mailer, EngineInterface $templating = null)
    {
        $this->mailer = $mailer;
	    $this->templating = $templating;
    }

	public function onPotCreated(PotEvent $event)
	{
		// ...
	}

	private function sendEmailToAdmin($pot, $template, $html = true)
	{
		$message = \Swift_Message::newInstance()
			->setSubject($pot->getOccasion())
			->setFrom(array('mailer@letskickin.com' => 'Letskickin'))
			->setTo($pot->getAdminEmail())
			->setBody(
				$this->templating->render(
					$template,
					array('pot' => $pot)
				)
			)
		;

		$contentType = $html == true ? 'text/html' : 'text/plain';

		$message->setContentType($contentType);

		$this->mailer->send($message);
	}

    public function onPotFlushed(PotEvent $event)
    {
        $pot = $event->getPot();

	    $this->sendEmailToAdmin($pot, 'letskickinFrontBundle:Email:potCreatedAdminLink.html.twig');
		$this->sendEmailToAdmin($pot, 'letskickinFrontBundle:Email:potCreatedInviteLink.txt.twig', false);
    }

	public function onPotUpdated(PotEvent $event)
	{
		$pot = $event->getPot();

		// Warn all the participants ??
	}

	public function onParticipantAdded(PotEvent $event)
	{
		$pot = $event->getPot();

		$this->sendEmailToAdmin($pot, 'letskickinFrontBundle:Email:potNewParticipant.txt.twig', false);

		// Warn all the participants ??
	}

	public function onParticipantRefused(PotEvent $event)
	{
		$pot = $event->getPot();

		$this->sendEmailToAdmin($pot, 'letskickinFrontBundle:Email:potParticipantRefused.txt.twig', false);

		// Warn all the participants ??
	}

    public static function getSubscribedEvents()
    {
        return array(
	        PotEvents::CREATED              => array('onPotCreated', 5),
	        PotEvents::FLUSHED              => array('onPotFlushed', 4),
	        PotEvents::UPDATED              => array('onPotUpdated', 3),
	        PotEvents::PARTICIPANT_ADDED    => array('onParticipantAdded', 2),
	        PotEvents::PARTICIPANT_REFUSED  => array('onParticipantRefused', 1),
		);
    }
}
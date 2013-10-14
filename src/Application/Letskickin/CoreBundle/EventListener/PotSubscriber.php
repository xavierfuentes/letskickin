<?php

namespace Application\Letskickin\CoreBundle\EventListener;

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

use Application\Letskickin\CoreBundle\Event\PotEvent;
use Application\Letskickin\CoreBundle\PotEvents;

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

	private function sendEmailToAdmin($pot, $template, $subject = null, $html = true)
	{
		if( null == $subject ) { $subject = $pot->getOccasion(); }

		$message = \Swift_Message::newInstance()
			->setSubject($subject)
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

        $this->sendEmailToAdmin($pot, 'ApplicationLetskickinFrontBundle:Email:potCreatedAdminLink.html.twig');
        $this->sendEmailToAdmin($pot, 'ApplicationLetskickinFrontBundle:Email:potCreatedInviteLink.txt.twig', 'Letskickin: ' . $pot->getOccasion(), false);
    }

	public function onPotUpdated(PotEvent $event)
	{
		$pot = $event->getPot();

		// Warn all the participants ??
	}

	public function onParticipantAdded(PotEvent $event)
	{
		$pot = $event->getPot();

        $this->sendEmailToAdmin($pot, 'ApplicationLetskickinFrontBundle:Email:potNewParticipant.txt.twig', 'Alguien ha contribuido a: ' . $pot->getOccasion(), false);

		// Warn all the participants ??
	}

	public function onParticipantRefused(PotEvent $event)
	{
		$pot = $event->getPot();

        $this->sendEmailToAdmin($pot, 'ApplicationLetskickinFrontBundle:Email:potParticipantRefused.txt.twig', 'Alguien no quiere participar en: ' . $pot->getOccasion(), false);

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
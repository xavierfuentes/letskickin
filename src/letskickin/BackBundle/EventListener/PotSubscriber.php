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

    public function onPotSaved(PotEvent $event)
    {
        $pot = $event->getPot();

		$messageHTML = \Swift_Message::newInstance()
			->setSubject($pot->getOccasion())
			->setFrom(array('mailer@letskickin.com' => 'Letskickin'))
			->setContentType('text/html')
			->setTo($pot->getAdminEmail())
			->setBody(
				$this->templating->render(
					'letskickinFrontBundle:Email:potCreatedAdminLink.html.twig',
					array('pot' => $pot)
				)
			)
		;
		$this->mailer->send($messageHTML);

	    $messageTXT = \Swift_Message::newInstance()
		    ->setSubject('Letskickin: "' . $pot->getOccasion() . '"')
		    ->setFrom(array('mailer@letskickin.com' => 'Letskickin'))
		    ->setContentType('text/html')
		    ->setTo($pot->getAdminEmail())
		    ->setBody(
			    $this->templating->render(
				    'letskickinFrontBundle:Email:potCreatedInviteLink.html.twig',
				    array('pot' => $pot)
			    )
		    )
	    ;
	    $this->mailer->send($messageTXT);
    }

	public function onPotUpdated(PotEvent $event)
	{
		$pot = $event->getPot();

		$message = \Swift_Message::newInstance()
			->setSubject($pot->getOccasion())
			->setFrom('mailer@letskickin.com')
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

	public function onParticipantAdded(PotEvent $event)
	{
		$pot = $event->getPot();

		$message = \Swift_Message::newInstance()
			->setSubject($pot->getOccasion())
			->setFrom('mailer@letskickin.com')
			->setTo($pot->getAdminEmail())
//			->setBody(
//				$this->renderView(
//					'HelloBundle:Hello:email.txt.twig',
//					array('name' => $name)
//				)
//			)
			->setBody("Hi " . $pot->getAdminName() . ", a new participant contributed to: " . $pot->getOccasion())
		;
		$this->mailer->send($message);

		// Warn all the participants
	}

    public static function getSubscribedEvents()
    {
        return array(
	        PotEvents::CREATED              => array('onPotCreated', 5),
	        PotEvents::SAVED                => array('onPotSaved', 4),
	        PotEvents::UPDATED              => array('onPotUpdated', 3),
	        PotEvents::PARTICIPANT_ADDED    => array('onParticipantAdded', 2),
		);
    }
}
<?php

namespace letskickin\BackBundle\EventListener;

use letskickin\BackBundle\Event\PotEvent;
use letskickin\BackBundle\PotEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class PotListener implements EventSubscriberInterface
{
    private $mailer;

    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function onCreatePot(PotEvent $event)
    {
        $pot = $event->getPot();

        /*foreach ($pot->getGuests() as $subscriber) {
            $message = Swift_Message::newInstance()
                ->setSubject($pot->getOccasion())
                ->setFrom('send@example.com')
                ->setTo($subscriber->getEmail())
                ->setBody("Hey, somebody invited you to chip in a pot! It says: " . $pot->getOccasion())
            ;
            $this->mailer->send($message);
        }*/
    }

    public static function getSubscribedEvents()
    {
        return array(PotEvents::POT_CREATED => 'onCreatePot');
    }
}
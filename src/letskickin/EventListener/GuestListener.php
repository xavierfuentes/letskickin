<?php

namespace letskickin\BackBundle\EventListener;

use letskickin\BackBundle\Event\GuestEvent;

class GuestListener
{
    protected $mailer;

    public function __construct(Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function onAddGuestEvent(GuestEvent $event)
    {
        $pot = $event->getPot();
        $guest = $event->getGuest();

        /*foreach ($post->getSubscribers() as $subscriber) {
            $message = Swift_Message::newInstance()
                ->setSubject('New comment posted on ' . $post->getTitle())
                ->setFrom('send@example.com')
                ->setTo($subscriber->getEmail())
                ->setBody("Hey, somebody left a new comment on a post you're subscribed to! It says: " . $comment->getBody())
            ;
            $this->mailer->send($message);
        }*/
    }
}
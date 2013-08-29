<?php

namespace letskickin\BackBundle\Doctrine;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

use letskickin\BackBundle\Event\GuestEvent;

class GuestManager
{
    /**
     * Holds the Symfony2 event dispatcher service
     */
    protected $dispatcher;

    /**
     * Holds the Doctrine entity manager for database interaction
     * @var EntityManager
     */
    protected $em;

    /**
     * Entity-specific repo, useful for finding entities, for example
     * @var EntityRepository
     */
    protected $repo;

    /**
     * The Fully-Qualified Class Name for our entity
     * @var string
     */
    protected $class;

    public function __construct(EventDispatcherInterface $dispatcher, EntityManager $em, $class)
    {
        $this->dispatcher = $dispatcher;
        $this->em = $em;
        $this->class = $class;
        $this->repo = $em->getRepository($class);
    }

    /**
     * @return Guest
     */
    public function createGuest()
    {
        $class = $this->class;
        $guest = new $class();

        return $guest;
    }

    public function saveGuest(Pot $pot, Guest $guest)
    {
        $guest->setPot($pot);
        $this->em->persist($guest);
        $this->em->flush();
        $this->dispatcher->dispatch('letskickin.pot.guest_added', new GuestEvent($pot, $guest));
    }
}
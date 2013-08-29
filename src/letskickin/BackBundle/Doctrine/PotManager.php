<?php

namespace letskickin\BackBundle\Doctrine;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Security\Core\Util\SecureRandom;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityRepository;

use letskickin\BackBundle\Entity\Pot;
use letskickin\BackBundle\PotEvents;
use letskickin\BackBundle\Event\PotEvent;

class PotManager
{
    /**
     * Holds the Symfony2 event dispatcher service
     */
    protected $dispatcher;

    /**
     * Holds the Doctrine object manager for database interaction
     * @var ObjectManager
     */
    protected $om;

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

    // Created but not finished
    const INACTIVE = 0;
    // Created and valid
    const ACTIVE = 1;

    // Bank transfer
    const TRANSFER = 0;

    public function __construct(EventDispatcherInterface $dispatcher, ObjectManager $om, $class)
    {
        $this->dispatcher = $dispatcher;
        $this->om = $om;
        $this->class = $class;
        $this->repo = $om->getRepository($class);
    }

    /**
     * @return Pot
     */
    public function find($pot_id)
    {
        return $this->repo->find($pot_id);
    }

    /**
     * @return Pot
     */
    public function createPot()
    {
        $class = $this->class;
        $pot = new $class();

        $generator = new SecureRandom();

        // Basic data default values
        $pot->setStatus(self::INACTIVE);
        $pot->setCreationDate(new \DateTime);

        $pot_id = $generator->nextBytes(10);
        $pot->setPotId($pot_id);

        $user_id = $generator->nextBytes(5);
        $pot->setUserId($user_id);

        // Money default values
        $pot->setCurrency("EUR");
        $pot->setCollectionMethod(self::TRANSFER);

        // Extra default values
        $pot->setNotificationsActive(false);
        $pot->setGuestsInvite(false);
        $pot->setRemindersActive(false);

        // Guests default values
        $pot->setTrackingActive(false);

        return $pot;
    }

    public function savePot(Pot $pot)
    {
        $this->om->persist($pot);
        $this->om->flush();

        $event = new PotEvent($pot);
        $this->dispatcher->dispatch(PotEvents::POT_CREATED, $event);
    }

}
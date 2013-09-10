<?php

namespace letskickin\BackBundle\Doctrine;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Security\Core\Util\SecureRandom;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityRepository;

use letskickin\BackBundle\Entity\Pot;
use letskickin\BackBundle\PotEvents;
use letskickin\BackBundle\Event\PotEvent;
use letskickin\BackBundle\ParticipantEvents;
use letskickin\BackBundle\Event\ParticipantEvent;

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

	// Anonymous pot
	const OWNER_ANONYMOUS = null;

    // Created but not finished
    const STATUS_INACTIVE = 0;
    // Created and valid
    const STATUS_ACTIVE = 1;

    // Bank transfer
    const METHOD_TRANSFER = 0;

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
    public function find($pot_key)
    {
        return $this->repo->findOneBy(array('pot_key' => $pot_key));
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
	    $pot->setOwner(self::OWNER_ANONYMOUS);
        $pot->setStatus(self::STATUS_INACTIVE);
        $pot->setCreationDate(new \DateTime);

        $pot_key = bin2hex($generator->nextBytes(8));
        $pot->setPotKey($pot_key);

        $admin_key = bin2hex($generator->nextBytes(4));
        $pot->setAdminKey($admin_key);

        // Money default values
	    $pot->setCurrency("EUR");
        $pot->setCollectionMethod(self::METHOD_TRANSFER);

        // Extra default values
        $pot->setNotificationsActive(false);
        $pot->setParticipantsInvite(false);
        $pot->setRemindersActive(false);

        // Guests default values
        $pot->setTrackingActive(false);

		$event = new PotEvent($pot);
		$this->dispatcher->dispatch(PotEvents::CREATED, $event);

        return $pot;
    }

    public function savePot(Pot $pot, $status = self::STATUS_ACTIVE)
    {
		$pot->setStatus($status);

	    $this->om->persist($pot);
	    $this->om->flush();

	    $event = new PotEvent($pot);
	    $this->dispatcher->dispatch(PotEvents::SAVED, $event);
    }

	public function updatePot(Pot $pot)
	{
		$this->savePot($pot);

		$event = new PotEvent($pot);
		$this->dispatcher->dispatch(PotEvents::UPDATED, $event);
	}

	public function setPremiumPot(Pot $pot)
	{
		$pot->setTrackingActive(true);
		$pot->setNotificationsActive(true);
		$pot->setParticipantsInvite(true);
		$pot->setRemindersActive(true);

		$this->om->persist($pot);
		$this->om->flush();

		$event = new PotEvent($pot);
		$this->dispatcher->dispatch(PotEvents::PREMIUM, $event);
	}

}
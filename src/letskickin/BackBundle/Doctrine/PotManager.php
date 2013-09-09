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

	    if(false === $pot->getParticipants()->isEmpty()) {
		    $this->addParticipants($pot);
	    }

	    $event = new PotEvent($pot);
	    $this->dispatcher->dispatch(PotEvents::SAVED, $event);
    }

	public function addParticipants(Pot $pot)
	{
		$participants = $pot->getParticipants();

		foreach($participants as $person) {
			$generator = new SecureRandom();

			// default data for every participant
			$person->setDate(new \DateTime);
			$person->setKey(bin2hex($generator->nextBytes(4)));
			$person->setStatus($person::STATUS_WAITING);

			$pot->addParticipant($person);

		    $event = new PotEvent($pot);
		    $this->dispatcher->dispatch(PotEvents::PARTICIPANT_ADDED, $event);
		}

		$event = new PotEvent($pot);
		$this->dispatcher->dispatch(PotEvents::PARTICIPANTS_ADDED, $event);
	}

}
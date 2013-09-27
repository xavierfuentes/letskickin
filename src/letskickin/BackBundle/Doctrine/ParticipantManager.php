<?php

namespace letskickin\BackBundle\Doctrine;

use letskickin\BackBundle\Entity\Pot;
use letskickin\BackBundle\PotEvents;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Security\Core\Util\SecureRandom;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityRepository;

use letskickin\BackBundle\Entity\Participant;
use letskickin\BackBundle\ParticipantEvents;
use letskickin\BackBundle\Event\ParticipantEvent;
use letskickin\BackBundle\Event\PotEvent;

class ParticipantManager
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

	const STATUS_NO_PARTICIPATES = 0;
	const STATUS_WAITING = 1;
	const STATUS_CONFIRMED = 2;

	public function __construct(EventDispatcherInterface $dispatcher, ObjectManager $om, $class)
	{
		$this->dispatcher = $dispatcher;
		$this->om = $om;
		$this->class = $class;
		$this->repo = $om->getRepository($class);
	}

	/**
	 * @return Participant
	 */
	public function find($participant_key)
	{
		$participant = $this->repo->findOneBy(array('participant_key' => $participant_key));

		return $participant;
	}

	/**
	 * @return Participant
	 */
	public function addParticipant(Pot $pot)
	{
		$class = $this->class;
		$participant = new $class();

		$participant->setStatus(self::STATUS_WAITING);
		$participant->setPot($pot);

		$generator = new SecureRandom();
		$participant->setParticipantKey(bin2hex($generator->nextBytes(16)));

		$participant->setDate(new \DateTime);

		return $participant;
	}

	/**
	 * @return Participant
	 */
	public function notParticipant(Participant $participant)
	{
		$participant->setStatus(self::STATUS_NO_PARTICIPATES);
		$participant->setAmount(0);

		return $participant;
	}

	public function saveParticipant(Participant $participant)
	{
		if( $participant->getAmount() == 0 ) {
			$this->notParticipant($participant);
		}

		$this->om->persist($participant);
		$this->om->flush();

		$event = new PotEvent($participant->getPot());
		$this->dispatcher->dispatch(PotEvents::PARTICIPANT_ADDED, $event);

		return true;
	}

}
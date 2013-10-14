<?php

namespace Application\Letskickin\CoreBundle\Doctrine;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Security\Core\Util\SecureRandom;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityRepository;

use Application\Letskickin\CoreBundle\Entity\Participant;
use Application\Letskickin\CoreBundle\Entity\Pot;
use Application\Letskickin\CoreBundle\Event\PotEvent;
use Application\Letskickin\CoreBundle\PotEvents;

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

    // not registered user's pot. If registered, the owner is a User object
    const OWNER_ANONYMOUS = null;

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
    public function find($id)
    {
        $pot = $this->repo->findOneBy(array('id' => $id));

        return $pot;
    }

    /**
     * @return Pot
     */
    public function findByKey($pot_key)
    {
        $pot = $this->repo->findOneBy(array('pot_key' => $pot_key));

        return $pot;
    }

    /**
     * @return Pot
     */
    public function createPot($eventsActive = true)
    {
        $class = $this->class;
        $pot = new $class();

        $generator = new SecureRandom();

        // Basic data default values
        $pot->setOwner(self::OWNER_ANONYMOUS);
        $pot->setStatus($pot::STATUS_INACTIVE);

        $date = new \DateTime;
        $pot->setCreationDate($date);
        $pot->setLastEditionDate($date);

        $pot_key = bin2hex($generator->nextBytes(8));
        $pot->setPotKey($pot_key);

        $admin_key = bin2hex($generator->nextBytes(4));
        $pot->setAdminKey($admin_key);

        // Money default values
        $pot->setCurrency("EUR");
        $pot->setCollectionMethod($pot::METHOD_TRANSFER);

        if(true === $eventsActive) {
            $event = new PotEvent($pot);
            $this->dispatcher->dispatch(PotEvents::CREATED, $event);
        }

        return $pot;
    }

    public function updatePot(Pot $pot, $status = null, $eventsActive = true)
    {
        $status = null === $status ? $pot::STATUS_ACTIVE : $status;

        $pot->setStatus($status);

        $date = new \DateTime;
        $pot->setLastEditionDate($date);

        if(true === $eventsActive) {
            $event = new PotEvent($pot);
            $this->dispatcher->dispatch(PotEvents::UPDATED, $event);
        }

        $this->om->persist($pot);
        $this->om->flush();

        return true;
    }

    public function savePot(Pot $pot, $status = null, $eventsActive = true)
    {
        $status = null === $status ? $pot::STATUS_ACTIVE : $status;

        $pot->setStatus($status);

        $this->om->persist($pot);
        $this->om->flush();

        if(true === $eventsActive) {
            $event = new PotEvent($pot);
            $this->dispatcher->dispatch(PotEvents::FLUSHED, $event);
        }

        return true;
    }

}
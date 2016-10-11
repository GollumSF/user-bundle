<?php
namespace GollumSF\UserBundle\Manager;

use Doctrine\ORM\EntityManagerInterface;
use GollumSF\UserBundle\Entity\Repository\UserConnectionRepositoryInterface;
use GollumSF\UserBundle\Entity\UserConnectionInterface;
use GollumSF\UserBundle\Entity\UserInterface;
use GollumSF\UserBundle\Event\AddUserConnectionEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * UserConnectionManagerTrait
 *
 * @author Damien Duboeuf <smeagolworms4@gmail.com>
 */
trait UserConnectionManagerTrait {
	
	/**
	 * @var EntityManagerInterface
	 */
	private $em;
	
	/**
	 * @var string
	 */
	private $entityClass;
	
	/**
	 * @var EventDispatcherInterface
	 */
	private $eventDispatcher;
	
	public function setEntityManager(EntityManagerInterface $em) {
		$this->em = $em;
	}
	
	/**
	 * @param string $entityClass
	 */
	public function setEntityClass($entityClass) {
		$this->entityClass = $entityClass;
	}
	
	/**
	 * @param EventDispatcherInterface $eventDispatcher
	 */
	public function setEventDispatcher(EventDispatcherInterface $eventDispatcher) {
		$this->eventDispatcher = $eventDispatcher;
	}
	
	/**
	 * @return EntityManagerInterface
	 */
	public function getEntityManager() {
		return $this->em;
	}
	
	/**
	 * @return string
	 */
	public function getEntityClass() {
		return $this->entityClass;
	}
	
	/**
	 * @return EventDispatcherInterface
	 */
	public function getEventDispatcher() {
		return $this->eventDispatcher;
	}
	
	/**
	 * @return UserConnectionRepositoryInterface
	 */
	public function getRepository() {
		return $this->getEntityManager()->getRepository($this->getEntityClass());
	}
	
	/**
	 * @param string $provider
	 * @param string $providerId
	 * @param UserInterface $user
	 * @param boolean $confirmed
	 * @return UserConnectionInterface
	 */
	public function createUserConnection($provider, $providerId, UserInterface $user, $confirmed = true) {
		$class = $this->getEntityClass();
		/** @var UserConnectionInterface $userConnection */
		$userConnection = new $class();
		$userConnection
			->setProvider($provider)
			->setProviderId($providerId)
			->setUser($user)
			->setConfirmed($confirmed)
		;
		$em = $this->getEntityManager();
		$em->persist($userConnection);
		$em->flush();
		
		$event = new AddUserConnectionEvent($userConnection);
		$this->getEventDispatcher()->dispatch(AddUserConnectionEvent::NAME, $event);
		
		return $userConnection;
	}
	
	/**
	 * @param string $email
	 * @return UserConnectionInterface
	 */
	public function findOneByEmailWithUserEnabled($email) {
		return $this->getRepository()->findOneByEmailWithUserEnabled($email);
	}
	
}
<?php
namespace GollumSF\UserBundle\Manager;

use Doctrine\ORM\EntityManagerInterface;
use GollumSF\UserBundle\Entity\Repository\UserRepositoryInterface;
use GollumSF\UserBundle\Entity\UserConnectionInterface;
use GollumSF\UserBundle\Entity\UserInterface;
use GollumSF\UserBundle\Event\RegisterUserEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * UserManagerTrait
 *
 * @author Damien Duboeuf <smeagolworms4@gmail.com>
 */
trait UserManagerTrait {
	
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
	
	/**
	 * @var UserConnectionManagerInterface
	 */
	private $userConnectionManager;
	
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
	 * @param UserConnectionManagerInterface $userConnectionManager
	 */
	public function setUserConnectionManager(UserConnectionManagerInterface $userConnectionManager) {
		$this->userConnectionManager = $userConnectionManager;
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
	 * @return UserConnectionManagerInterface
	 */
	public function getUserConnectionManager() {
		return $this->userConnectionManager;
	}
	
	/**
	 * @return UserRepositoryInterface
	 */
	public function getRepository() {
		return $this->getEntityManager()->getRepository($this->getEntityClass());
	}
	
	/**
	 * @param mixed $entity
	 * @return mixed
	 */
	public function update($entity) {
		if (is_object($entity)) {
			$em = $this->getEntityManager();
			$em->persist($entity);
			$em->flush($entity);
		}
		return $entity;
	}
	
	/**
	 * @return UserInterface
	 */
	public function createUser() {
		$class = $this->getEntityClass();
		return new $class;
	}
	
	/**
	 * @param UserInterface $user
	 * @return UserInterface
	 */
	public function register(UserInterface $user) {
		
		$user->setSalt(uniqid());
		
		// TODO add to update entity event
		$user->setPassword(sha1($user->getPlainPassword()));
		$user->eraseCredentials();
		
		$this->update($user);
		
		if ($user->getEmail()) {
			$this->userConnectionManager->createUserConnection(UserConnectionInterface::PROVIDER_EMAIL, $user->getEmail(), $user, false);
		}
		
		$event = new RegisterUserEvent($user);
		$this->getEventDispatcher()->dispatch(RegisterUserEvent::NAME, $event);
		
		return $user;
	}
	
	/**
	 * @return UserInterface
	 */
	public function findOneEnabledByEmail($email) {
		$userConnection = $this->userConnectionManager->findOneByEmailWithUserEnabled($email);
		return $userConnection ? $userConnection->getUser() : NULL;
	}
	
	/**
	 * @return UserInterface
	 */
	public function findOneEnabledById($email) {
		return $this->getRepository()->findOneEnabledById($email);
	}
	
}
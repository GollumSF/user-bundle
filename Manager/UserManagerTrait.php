<?php
namespace GollumSF\UserBundle\Manager;

use Doctrine\ORM\EntityManagerInterface;
use GollumSF\UserBundle\Entity\Repository\UserRepository;
use GollumSF\UserBundle\Entity\UserInterface;

/**
 * UserManagerTrait
 *
 * @author Damien Duboeuf <smeagolworms4@gmail.com>
 */
trait UserManagerTrait {
	
	/**
	 * @var EntityManager
	 */
	private $em;
	
	/**
	 * @var string
	 */
	private $entityClass;
	
	public function setEntityClass($entityClass) {
		$this->entityClass = $entityClass;
	}
	
	public function setEntityManager(EntityManagerInterface $em) {
		$this->em = $em;
	}
	
	/**
	 * @return string
	 */
	public function getEntityClass() {
		return $this->entityClass;
	}
	
	/**
	 * @return EntityManagerInterface
	 */
	public function getEntityManager() {
		return $this->em;
	}
	
	/**
	 * @return UserRepository
	 */
	public function getRepository() {
		return $this->getEntityManager()->getRepository($this->getEntityClass());
	}
	
	/**
	 * @return UserInterface
	 */
	public function createUser() {
		$class = $this->getEntityClass();
		return new $class;
	}
	
	/**
	 * @return UserInterface
	 */
	public function findOneEnabledByEmail($email) {
		return $this->getRepository()->findOneEnabledByEmail($email);
	}
	
}
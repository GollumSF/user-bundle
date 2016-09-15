<?php
namespace GollumSF\AuthRestBundle\Manager;
use GollumSF\AuthRestBundle\Entity\UserInterface;

/**
 * UserManagerInterface
 *
 * @author Damien Duboeuf <smeagolworms4@gmail.com>
 */
interface UserManagerInterface {
	
	/**
	 * @return string
	 */
	public function getEntityClass();
	
	/**
	 * @return UserInterface
	 */
	public function createUser();
	
	/**
	 * @return UserInterface
	 */
	public function findOneEnabledByEmail($email);
}
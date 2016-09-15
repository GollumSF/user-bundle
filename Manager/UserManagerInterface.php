<?php
namespace GollumSF\UserBundle\Manager;

use GollumSF\UserBundle\Entity\UserInterface;

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
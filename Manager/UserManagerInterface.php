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
	 * @return UserInterface
	 */
	public function createUser();
	
	/**
	 * @param UserInterface $user
	 * @return UserInterface
	 */
	public function register(UserInterface $user);
	
	/**
	 * @return UserInterface
	 */
	public function findOneEnabledById($id);
	
	/**
	 * @return UserInterface
	 */
	public function findOneEnabledByEmail($email);
	
}
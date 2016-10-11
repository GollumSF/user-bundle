<?php
namespace GollumSF\UserBundle\Manager;

use GollumSF\UserBundle\Entity\UserConnectionInterface;
use GollumSF\UserBundle\Entity\UserInterface;

/**
 * UserManagerInterface
 *
 * @author Damien Duboeuf <smeagolworms4@gmail.com>
 */
interface UserConnectionManagerInterface {
	
	/**
	 * @param string $provider
	 * @param string $providerId
	 * @param UserInterface $user
	 * @param boolean $confirmed
	 * @return UserConnectionInterface
	 */
	public function createUserConnection($provider, $providerId, UserInterface $user, $confirmed = true);
	
	/**
	 * @param string $email
	 * @return UserConnectionInterface
	 */
	public function findOneByEmailWithUserEnabled($email);
	
}
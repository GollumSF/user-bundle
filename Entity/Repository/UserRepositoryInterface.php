<?php
namespace GollumSF\UserBundle\Entity\Repository;

use GollumSF\UserBundle\Entity\UserInterface;

/**
 * UserRepositoryInterface
 *
 * @author Damien Duboeuf <smeagolworms4@gmail.com>
 */
interface UserRepositoryInterface {
	
	/**
	 * @return UserInterface
	 */
	public function findOneEnabledByEmail($email);
	
}
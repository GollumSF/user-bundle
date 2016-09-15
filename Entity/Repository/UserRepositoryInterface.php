<?php
namespace GollumSF\AuthRestBundle\Entity\Repository;

use GollumSF\AuthRestBundle\Entity\UserInterface;

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
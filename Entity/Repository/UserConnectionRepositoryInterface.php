<?php
namespace GollumSF\UserBundle\Entity\Repository;
use GollumSF\UserBundle\Entity\UserConnectionInterface;

/**
 * UserConnectionRepositoryInterface
 *
 * @author Damien Duboeuf <smeagolworms4@gmail.com>
 */
interface UserConnectionRepositoryInterface {
	
	/**
	 * @param string $email
	 * @return UserConnectionInterface
	 */
	public function findOneByEmailWithUserEnabled($email);
	
}
<?php
namespace GollumSF\UserBundle\Entity\Repository;

use GollumSF\UserBundle\Entity\UserInterface;

/**
 * UserRepositoryTrait
 *
 * @author Damien Duboeuf <smeagolworms4@gmail.com>
 */
trait UserRepositoryTrait {
	
	/**
	 * @return UserInterface
	 */
	public function findOneEnabledByEmail($email) {
		return $this->findOneBy([
			'enabled' => true,
			'email'   => $email,
		]);
	}
}
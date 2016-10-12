<?php
namespace GollumSF\UserBundle\Entity\Repository;

use GollumSF\UserBundle\Entity\UserConnectionInterface;

/**
 * UserConnectionRepositoryTrait
 *
 * @author Damien Duboeuf <smeagolworms4@gmail.com>
 */
trait UserConnectionRepositoryTrait {
	
	/**
	 * @param string $email
	 * @return UserConnectionInterface
	 */
	public function findOneByEmailWithUserEnabled($email) {
		return $this->createQueryBuilder('c')
			->join('c.user', 'u')
			->where('c.provider = :provider')
			->andWhere('c.providerId = :email')
			->andWhere('u.enabled = :enabled')
			->setParameter('provider', UserConnectionInterface::PROVIDER_EMAIL)
			->setParameter('email', $email)
			->setParameter('enabled', true)
			->getQuery()
			->getSingleResult()
		;
	}
	
}
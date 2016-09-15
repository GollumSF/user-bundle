<?php
namespace GollumSF\AuthRestBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * UserTokenRepository
 *
 * @author Damien Duboeuf <smeagolworms4@gmail.com>
 */
class UserTokenRepository extends EntityRepository implements  UserTokenRepositoryInterface {
	
	use UserTokenRepositoryTrait;
	
}
<?php
namespace GollumSF\UserBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * UserRepository
 *
 * @author Damien Duboeuf <smeagolworms4@gmail.com>
 */
class UserRepository extends EntityRepository implements  UserRepositoryInterface {
	
	use UserRepositoryTrait;
	
}
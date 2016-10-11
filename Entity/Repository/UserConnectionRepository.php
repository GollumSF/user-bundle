<?php
namespace GollumSF\UserBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * UserConnectionRepository
 *
 * @author Damien Duboeuf <smeagolworms4@gmail.com>
 */
class UserConnectionRepository extends EntityRepository implements  UserConnectionRepositoryInterface {
	
	use UserConnectionRepositoryTrait;
	
}
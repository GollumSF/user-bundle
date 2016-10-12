<?php
namespace GollumSF\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use GollumSF\UserBundle\Entity\Repository\UserConnectionRepository;

/**
 * UserConnection
 * 
 * @author Damien Duboeuf <smeagolworms4@gmail.com>
 * 
 * @ORM\Entity(repositoryClass=UserConnectionRepository::class)
 * @ORM\Table(name="user_connection")
 */
class UserConnection implements UserConnectionInterface {
	
	use UserConnectionTrait;
	
	public function __construct() {
		$this->updatedAt = new \DateTime();
		$this->createdAt = new \DateTime();
	}
}
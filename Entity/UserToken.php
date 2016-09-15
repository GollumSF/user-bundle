<?php
namespace GollumSF\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use GollumSF\UserBundle\Entity\Repository\UserTokenRepository;

/**
 * User
 * 
 * @author Damien Duboeuf <smeagolworms4@gmail.com>
 * 
 * @ORM\Entity(repositoryClass=UserTokenRepository::class)
 * @ORM\Table(name="user_token")
 */
class UserToken implements UserTokenInterface {
	
	use UserTokenTrait;
	
	public function __construct() {
		$this->updatedAt = new \DateTime();
		$this->createdAt = new \DateTime();
	}
}
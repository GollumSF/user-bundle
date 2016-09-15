<?php
namespace GollumSF\AuthRestBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use GollumSF\AuthRestBundle\Entity\Repository\UserRepository;

/**
 * User
 * 
 * @author Damien Duboeuf <smeagolworms4@gmail.com>
 * 
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="user")
 */
class User implements UserInterface {
	
	const ROLE_DEFAULT = 'ROLE_USER';
	
	use UserTrait;
	
	public function __construct() {
		$this->userTokens = new ArrayCollection();
		$this->updatedAt  = new \DateTime();
		$this->createdAt  = new \DateTime();
	}
}
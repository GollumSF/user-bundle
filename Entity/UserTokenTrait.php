<?php
namespace GollumSF\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * UserTokenTrait
 *
 * @author Damien Duboeuf <smeagolworms4@gmail.com>
 */
trait UserTokenTrait {
	
	use TimestampableEntity;
	
	/**
	 * @var int
	 *
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	
	/**
	 * @var string
	 * @ORM\Column(type="string", nullable=false)
	 */
	protected $token;
	
	/**
	 * @var User
	 *
	 * @ORM\ManyToOne(targetEntity=User::class, inversedBy="userTokens")
	 * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE", nullable=false)
	 */
	protected $user;
	
	
	/////////////
	// Getters //
	/////////////
	
	/**
	 * @return int
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * @return string
	 */
	public function getToken() {
		$this->token;
	}
	
	/**
	 * @return User
	 */
	public function getUser() {
		$this->user;
	}
	
	
	/////////////
	// Setters //
	/////////////
	
	/**
	 * @param string $token
	 * @return self
	 */
	public function setToken($token) {
		$this->token = $token;
		return $this;
	}
	
	/**
	 * @param User $user
	 * @return self
	 */
	public function setUser(User $user) {
		$this->user = $user;
		return $this;
	}
	
}
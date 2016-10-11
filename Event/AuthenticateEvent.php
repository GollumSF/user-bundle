<?php
namespace GollumSF\UserBundle\Event;

use GollumSF\UserBundle\Entity\UserInterface;
use GollumSF\UserBundle\Security\Token\GollumSFTokenInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * AuthenticateEvent
 *
 * @author Damien Duboeuf <smeagolworms4@gmail.com>
 */
class AuthenticateEvent extends Event {
	
	const NAME = 'gsf_user.authenticate';
	
	/**
	 * @var UserInterface
	 */
	protected $user;
	
	/**
	 * @var GollumSFTokenInterface
	 */
	protected $token;
	
	/**
	 * @var boolean
	 */
	protected $cancel = false;
	
	public function __construct(UserInterface $user, GollumSFTokenInterface $token) {
		$this->user  = $user;
		$this->token = $token;
	}
	
	/**
	 * @return UserInterface
	 */
	public function getUser() {
		return $this->user;
	}
	
	/**
	 * @return GollumSFTokenInterface
	 */
	public function getToken() {
		return $this->token;
	}
	
	/**
	 * @return boolean
	 */
	public function isCancel() {
		return $this->cancel;
	}
	
	/**
	 * @return self
	 */
	public function canceled() {
		$this->cancel = true;
		return $this;
	}
	
}
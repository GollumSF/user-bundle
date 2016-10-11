<?php
namespace GollumSF\UserBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface; 

/**
 * LogoutEvent
 *
 * @author Damien Duboeuf <smeagolworms4@gmail.com>
 */
class LogoutEvent extends Event {
	
	const NAME = 'gsf_user.logout';
	
	/**
	 * @var TokenInterface
	 */
	protected $token;
	
	/**
	 * @var boolean
	 */
	protected $cancel = false;
	
	public function __construct(TokenInterface $token) {
		$this->token = $token;
	}
	
	/**
	 * @return TokenInterface
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
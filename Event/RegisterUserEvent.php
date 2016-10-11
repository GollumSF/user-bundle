<?php
namespace GollumSF\UserBundle\Event;
use GollumSF\UserBundle\Entity\UserInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * RegisterUserEvent
 *
 * @author Damien Duboeuf <smeagolworms4@gmail.com>
 */
class RegisterUserEvent extends Event {
	
	const NAME = 'gsf_user.register_user';
	
	/**
	 * @var UserInterface
	 */
	protected $user;
	
	public function __construct(UserInterface $user) {
		$this->user = $user;
	}
	
	/**
	 * @return UserInterface
	 */
	public function getUser() {
		return $this->user;
	}
	
}
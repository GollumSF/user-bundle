<?php
namespace GollumSF\UserBundle\Event;

use GollumSF\UserBundle\Entity\UserInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * UserEvent
 *
 * @author Damien Duboeuf <smeagolworms4@gmail.com>
 */
abstract class UserEvent extends Event {
	
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
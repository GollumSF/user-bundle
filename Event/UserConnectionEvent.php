<?php
namespace GollumSF\UserBundle\Event;

use GollumSF\UserBundle\Entity\UserConnectionInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * UserConnectionEvent
 *
 * @author Damien Duboeuf <smeagolworms4@gmail.com>
 */
abstract class UserConnectionEvent extends Event {
	
	const NAME = 'gsf_user.add_user_connection';
	
	/**
	 * @var UserConnectionInterface
	 */
	protected $userConnection;
	
	public function __construct(UserConnectionInterface $userConnection) {
		$this->userConnection = $userConnection;
	}
	
	/**
	 * @return UserConnectionInterface
	 */
	public function getUserConnection() {
		return $this->userConnection;
	}
	
}
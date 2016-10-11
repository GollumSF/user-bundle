<?php
namespace GollumSF\UserBundle\EventListener;

use GollumSF\UserBundle\Entity\UserInterface;
use GollumSF\UserBundle\Event\AddUserConnectionEvent;
use GollumSF\UserBundle\Event\AuthenticateEvent;
use GollumSF\UserBundle\Event\LogoutEvent;
use GollumSF\UserBundle\Event\RegisterUserEvent;
use Psr\Log\LoggerInterface;

/**
 * LoggerListener
 *
 * @author Damien Duboeuf <smeagolworms4@gmail.com>
 */
class LoggerSubscriber {
	
	/**
	 * @var LoggerInterface
	 */
	private $logger;
	
	/**
	 * LoggerSubscriber constructor.
	 * @param LoggerInterface $logger
	 */
	public function __construct(LoggerInterface $logger) {
		$this->logger = $logger;
	}
	
	public function registerUserEvent(RegisterUserEvent $event) {
		$this->logger->info(sprintf('Register new User id=%s', $event->getUser()->getId()));
	}
	
	public function addUserConnectionEvent(AddUserConnectionEvent $event) {
		$uc = $event->getUserConnection();
		$this->logger->info(sprintf(
			'Register new UserConnection id=%s, provider=%s, providerId=%s, user id=%s',
			$uc->getId(),
			$uc->getProvider(),
			$uc->getProviderId(),
			$uc->getUser()->getId()
		));
	}
	
	public function authenticateEvent(AuthenticateEvent $event) {
		$this->logger->info(sprintf('Register new User id=%s', $event->getUser()->getId()));
	}
	
	public function logoutEvent(LogoutEvent $event) {
		$token = $event->getToken();
		$user = $token ? $token->getUser() : NULL;
		$this->logger->info(sprintf('Register new User id=%s', $user instanceof UserInterface ? $user->getId() : 'Unknown user'));
	}
	
	public static function getSubscribedEvents()
	{
		// return the subscribed events, their methods and priorities
		return [
			RegisterUserEvent::NAME      => ['registerUserEvent'     , 0],
			AddUserConnectionEvent::NAME => ['addUserConnectionEvent', 0],
			AuthenticateEvent::NAME      => ['authenticateEvent'     , 0],
			LogoutEvent::NAME            => ['logoutEvent'           , 0],
		];
	}
	
}
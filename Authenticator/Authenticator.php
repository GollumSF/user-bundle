<?php
namespace GollumSF\UserBundle\Authenticator;

use GollumSF\UserBundle\Entity\UserInterface;
use GollumSF\UserBundle\Event\AuthenticateEvent;
use GollumSF\UserBundle\Event\LogoutEvent;
use GollumSF\UserBundle\Security\Token\GollumSFToken;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Authenticator
 *
 * @author Damien Duboeuf <smeagolworms4@gmail.com>
 */
class Authenticator implements AuthenticatorInterface {
	
	/**
	 * @var TokenStorageInterface
	 */
	protected $tokenStorage;
	
	/**
	 * @var string
	 */
	protected $secret;
	
	/**
	 * @var RequestStack
	 */
	protected $requestStack;
	
	/**
	 * @var EventDispatcherInterface
	 */
	protected $eventDispatcher;
	
	public function __construct(TokenStorageInterface $tokenStorage, $secret, RequestStack $requestStack, EventDispatcherInterface $eventDispatcher) {
		$this->tokenStorage    = $tokenStorage;
		$this->secret          = $secret;
		$this->requestStack  = $requestStack;
		$this->eventDispatcher = $eventDispatcher;
	}
	
	/**
	 * @param UserInterface $user
	 * @return NULL|GollumSFToken
	 */
	public function authenticate(UserInterface $user) {
		$token = new GollumSFToken($user);
		$event = new AuthenticateEvent($user, $token);
		$this->eventDispatcher->dispatch(AuthenticateEvent::NAME, $event);
		if ($event->isCancel()) {
			return NULL;
		}
		$this->tokenStorage->setToken($token);
		return $token;
	}
	
	/**
	 * @return NULL|AnonymousToken
	 */
	public function logout() {
		$event = new LogoutEvent($this->tokenStorage->getToken());
		$this->eventDispatcher->dispatch(LogoutEvent::NAME, $event);
		if ($event->isCancel()) {
			return NULL;
		}
		$token = new AnonymousToken($this->secret, 'anon.');
		$this->tokenStorage->setToken($token);
		$this->getMasterRequest()->getSession()->invalidate();
		return $token;
	}
	
	/**
	 * @return Request
	 */
	protected function getMasterRequest() {
		return $this->requestStack->getMasterRequest();
	}
	
}
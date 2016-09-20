<?php
namespace GollumSF\UserBundle\Security\Firewall;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Security\Core\Authentication\AuthenticationManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Firewall\ListenerInterface;

/**
 * UserListener
 *
 * @author Damien Duboeuf <smeagolworms4@gmail.com>
 */
class UserListener implements ListenerInterface {
	
	/**
	 * @var TokenStorageInterface
	 */
	protected $tokenStorage;
	
	/**
	 * @var AuthenticationManagerInterface
	 */
	protected $authenticationManager;
	
	public function __construct(TokenStorageInterface $tokenStorage, AuthenticationManagerInterface $authenticationManager) {
		$this->tokenStorage = $tokenStorage;
		$this->authenticationManager = $authenticationManager;
	}
	
	/**
	 * This interface must be implemented by firewall listeners.
	 *
	 * @param GetResponseEvent $event
	 */
	public function handle(GetResponseEvent $event) {
		
		try {
			$token = $this->tokenStorage->getToken();
			if ($token) {
				$authToken = $this->authenticationManager->authenticate($token);
				$this->tokenStorage->setToken($authToken);
			}
		} catch (AuthenticationException $failed) {
			$message = 'Authentication Failed: '.$failed->getMessage();
			$authToken = new AnonymousToken('TheSecret', 'anon.', []);
			$this->tokenStorage->setToken($authToken);
		}
	}
}
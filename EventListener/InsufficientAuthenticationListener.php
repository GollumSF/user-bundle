<?php
namespace GollumSF\UserBundle\EventListener;

use GollumSF\UserBundle\Entity\UserInterface;
use GollumSF\UserBundle\Parameter\ParameterSelector;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Exception\InsufficientAuthenticationException;

/**
 * AccessDeniedExceptionListener
 *
 * @author Damien Duboeuf <smeagolworms4@gmail.com>
 */
class InsufficientAuthenticationListener {
	
	/**
	 * @var TokenStorageInterface
	 */
	private $tokenStorage;
	
	/**
	 * @var ParameterSelector
	 */
	private $urlSelector;
	
	public function __construct(TokenStorageInterface $tokenStorage, ParameterSelector $urlSelector) {
		$this->tokenStorage = $tokenStorage;
		$this->urlSelector  = $urlSelector;
	}
	
	/**
	 * @return UserInterface
	 */
	protected function getUser() {
		$token = $this->tokenStorage->getToken();
		if (!$token || !is_object($user = $token->getUser())) {
			return NULL;
		}
		return $user;
	}
	
	
	/**
	 * @return string
	 */
	protected function getLoginUrl(Request $request) {
		$url = $this->urlSelector->get('login');
		if (
			strpos($url, '//') !== 0 &&
			!filter_var($url, FILTER_VALIDATE_URL)
		) {
			$url = $request->getBaseUrl().$url;
		}
		return $url;
	}
	
	public function onKernelException(GetResponseForExceptionEvent $event) {
		
		$exception = $event->getException();
		$request   = $event->getRequest();
		$user      = $this->getUser();
		
		if (!$user && $exception instanceof InsufficientAuthenticationException) {
			$url = $this->getLoginUrl($request);
			$event->setResponse(new RedirectResponse($url.'?redirect='.urlencode($request->getRequestUri())));
		}
	}
	
}
<?php
namespace GollumSF\UserBundle\Security\Authentication\Provider;

use GollumSF\UserBundle\Entity\UserInterface;
use GollumSF\UserBundle\Manager\UserManagerInterface;
use GollumSF\UserBundle\Security\Token\GollumSFToken;
use GollumSF\UserBundle\Security\Token\GollumSFTokenInterface;
use Symfony\Component\Security\Core\Authentication\Provider\AuthenticationProviderInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

/**
 * GollumSFAuthenticationProvider
 *
 * @author Damien Duboeuf <smeagolworms4@gmail.com>
 */
class UserAuthenticationProvider implements AuthenticationProviderInterface {
	
	/**
	 * @var UserManagerInterface
	 */
	private $userManager;
	
	public function __construct(UserManagerInterface $userManager = NULL) {
		$this->userManager = $userManager;
	}
	
	/**
	 * @param GollumSFTokenInterface $token
	 * @return TokenInterface
	 */
	public function authenticate(TokenInterface $token) {
		$id = $token->getUserId();
		if ($id) {
			$user = $this->userManager->findOneEnabledById($id);
			if ($user) {
				if ($user instanceof UserInterface) {
					return new GollumSFToken($user);
				}
			}
		}
		throw new AuthenticationException('The GollumSF authentication failed.');
	}
	
	public function supports(TokenInterface $token) {
		return $token instanceof GollumSFTokenInterface;
	}
}
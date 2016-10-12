<?php
namespace GollumSF\UserBundle\Authenticator;

use GollumSF\UserBundle\Entity\UserInterface;
use GollumSF\UserBundle\Security\Token\GollumSFToken;

/**
 * AuthenticatorInterface
 *
 * @author Damien Duboeuf <smeagolworms4@gmail.com>
 */
interface AuthenticatorInterface {
	
	/**
	 * @param UserInterface $user
	 * @return GollumSFToken
	 */
	public function authenticate(UserInterface $user);
	
	/**
	 * @return NULL|AnonymousToken
	 */
	public function logout();
	
}
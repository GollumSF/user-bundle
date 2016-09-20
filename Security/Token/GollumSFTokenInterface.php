<?php
namespace GollumSF\UserBundle\Security\Token;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

/**
 * GollumSFTokenInterface
 *
 * @author Damien Duboeuf <smeagolworms4@gmail.com>
 */
interface GollumSFTokenInterface extends TokenInterface {
	
	/**
	 * @return int
	 */
	public function getUserId();
	
}
<?php
namespace GollumSF\AuthRestBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface as UserInterfaceBase;

/**Token
 * UserInterface
 *
 * @author Damien Duboeuf <smeagolworms4@gmail.com>
 */
interface UserTokenInterface {
	
	
	/////////////
	// Getters //
	/////////////
	
	/**
	 * @return int
	 */
	public function getId();
	
	/**
	 * @return string
	 */
	public function getToken();
	
	/**
	 * @return User
	 */
	public function getUser();
	
	/**
	 * Returns createdAt.
	 *
	 * @return \DateTime
	 */
	public function getCreatedAt();
	
	/**
	 * Returns updatedAt.
	 *
	 * @return \DateTime
	 */
	public function getUpdatedAt();
	
	
	/////////////
	// Setters //
	/////////////
	
	/**
	 * @param string $token
	 * @return self
	 */
	public function setToken($token);
	
	/**
	 * @param User $user
	 * @return self
	 */
	public function setUser(User $user);
	
	/**
	 * Sets createdAt.
	 *
	 * @param  \DateTime $createdAt
	 * @return $this
	 */
	public function setCreatedAt(\DateTime $createdAt);
	
	/**
	 * Sets updatedAt.
	 *
	 * @param  \DateTime $updatedAt
	 * @return $this
	 */
	public function setUpdatedAt(\DateTime $updatedAt);
	
}
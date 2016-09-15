<?php
namespace GollumSF\UserBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface as UserInterfaceBase;

/**
 * UserInterface
 *
 * @author Damien Duboeuf <smeagolworms4@gmail.com>
 */
interface UserInterface extends UserInterfaceBase {
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
	public function getEmail();
	
	/**
	 * @return string
	 */
	public function getPassword();
	
	/**
	 * @return string
	 */
	public function getPlainPassword();
	
	/**
	 * @return string|null
	 */
	public function getSalt();
	
	/**
	 * @return string[]
	 */
	public function getRoles();
	
	/**
	 * @return boolean
	 */
	public function isEnabled();
	
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
	 * @param string $email
	 * @return self
	 */
	public function setEmail($email);
	
	/**
	 * @param string $password
	 * @return self
	 */
	public function setPassword($password);
	
	/**
	 * @param string $plainPassword
	 * @return self
	 */
	public function setPlainPassword($plainPassword);
	
	/**
	 * @param string $salt
	 * @return self
	 */
	public function setSalt($salt);
	
	/**
	 * @param array $roles
	 * @return self
	 */
	public function setRoles(array $roles);
	
	/**
	 * @param boolean $enabled
	 */
	public function setEnabled($enabled);
	
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
	
	
	/////////
	// Add //
	/////////
	
	public function addRole($role);
	
	
	////////////
	// Remove //
	////////////
	
	public function removeRole($role);
	
	
	////////////
	// Others //
	////////////
	
	/**
	 * Never use this to check if this user has access to anything!
	 *
	 * Use the SecurityContext, or an implementation of AccessDecisionManager
	 * instead, e.g.
	 *
	 *         $securityContext->isGranted('ROLE_USER');
	 *
	 * @param string $role
	 * @return boolean
	 */
	public function hasRole($role);
	
	/**
	 * @return string
	 */
	public function getUsername();
	
	/**
	 * Removes sensitive data from the user.
	 */
	public function eraseCredentials();
}
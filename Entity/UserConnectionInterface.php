<?php
namespace GollumSF\UserBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface as UserInterfaceBase;

/**
 * UserConnectionInterface
 *
 * @author Damien Duboeuf <smeagolworms4@gmail.com>
 */
interface UserConnectionInterface {
	
	
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
	public function getProviderId();
	
	/**
	 * @return string
	 */
	public function getProvider();
	
	/**
	 * @return UserInterface
	 */
	public function getUser();
	
	/**
	 * @return boolean
	 */
	public function getConfirmed();
	
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
	 * @param string $providerId
	 * @return self
	 */
	public function setProviderId($providerId);
	
	/**
	 * @param string $providerId
	 * @return self
	 */
	public function setProvider($provider);
	
	/**
	 * @param UserInterface $user
	 * @return self
	 */
	public function setUser(UserInterface $user);
	
	/**
	 * @param boolean $confirmed
	 * @return self
	 */
	public function setConfirmed($confirmed);
	
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
<?php
namespace GollumSF\AuthRestBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * UserTrait
 *
 * @author Damien Duboeuf <smeagolworms4@gmail.com>
 */
trait UserTrait {
	
	use TimestampableEntity;
	
	/**
	 * @var int
	 *
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	
	/**
	 * @var string
	 * @ORM\Column(type="string", length=180)
	 */
	protected $email;
	
	/**
	 * @var string
	 * 
	 * @ORM\Column(type="string")
	 */
	protected $password;
	
	/**
	 * Plain password. Used for model validation. Must not be persisted.
	 * @var string
	 */
	protected $plainPassword;
	
	/**
	 * @var string
	 * 
	 * @ORM\Column(type="string", nullable=false)
	 */
	protected $salt;
	
	/**
	 * @var int
	 * 
	 * @ORM\Column(type="text", nullable=false)
	 */
	protected $roles;
	
	/**
	 * @var boolean
	 *
	 * @ORM\Column(type="boolean", nullable=false)
	 */
	protected $enabled;
	
	/**
	 * @var ArrayCollection
	 *
	 * @ORM\OneToMany(targetEntity=UserToken::class, mappedBy="user")
	 */
	protected $userTokens;
	
	/////////////
	// Getters //
	/////////////
	
	/**
	 * @return int
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * @return string
	 */
	public function getEmail() {
		$this->email;
	}
	
	/**
	 * @return string
	 */
	public function getPassword() {
		$this->password;
	}
	
	/**
	 * @return string
	 */
	public function getPlainPassword() {
		$this->plainPassword;
	}
	
	/**
	 * @return string|null
	 */
	public function getSalt() {
		return $this->salt;
	}
	
	/**
	 * @return string[]
	 */
	public function getRoles() {
		$roles = explode('|', $this->roles);
		$roles[] = User::ROLE_DEFAULT;
		return array_unique($roles);
	}
	
	/**
	 * @return boolean
	 */
	public function isEnabled() {
		return $this->enabled;
	}
	
	
	/////////////
	// Setters //
	/////////////
	
	/**
	 * @param string $email
	 * @return self
	 */
	public function setEmail($email) {
		$this->email = $email;
		return $this;
	}
	
	/**
	 * @param string $password
	 * @return self
	 */
	public function setPassword($password) {
		$this->password = $password;
		return $this;
	}
	
	/**
	 * @param string $plainPassword
	 * @return self
	 */
	public function setPlainPassword($plainPassword) {
		$this->plainPassword = $plainPassword;
		return $this;
	}
	
	/**
	 * @param string $salt
	 * @return self
	 */
	public function setSalt($salt) {
		$this->salt = $salt;
		return $this;
	}
	
	/**
	 * @param array $roles
	 * @return self
	 */
	public function setRoles(array $roles) {
		
		$this->roles = [];
		foreach ($roles as $role) {
			$this->addRole($role);
		}
		return $this;
	}
	
	/**
	 * @param boolean $enabled
	 */
	public function setEnabled($enabled) {
		$this->enabled = $enabled;
	}
	
	
	/////////
	// Add //
	/////////
	
	public function addRole($role) {
		$role = strtoupper($role);
		if ($role === User::ROLE_DEFAULT) {
			return $this;
		}
		$roles = $this->getRoles();
		if (!in_array($role, $roles, true)) {
			$roles[] = $role;
		}
		$this->roles = implode('|', $roles);
		return $this;
	}
	
	
	////////////
	// Remove //
	////////////
	
	public function removeRole($role) {
		$role = strtoupper($role);
		$roles = $this->getRoles();
		if (false !== $key = array_search($role, $roles, true)) {
			unset($roles[$key]);
			$this->setRoles($roles);
		}
		return $this;
	}
	
	
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
	public function hasRole($role) {
		return in_array(strtoupper($role), $this->getRoles(), true);
	}
	
	/**
	 * @return string
	 */
	public function getUsername() {
		return $this->getEmail();
	}
	
	/**
	 * Removes sensitive data from the user.
	 */
	public function eraseCredentials() {
		$this->plainPassword = null;
	}
	
}
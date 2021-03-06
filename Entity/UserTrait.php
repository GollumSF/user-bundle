<?php
namespace GollumSF\UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;

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
	 * 
	 * @ORM\Column(type="string", length=180)
	 * 
	 * @Assert\NotBlank(groups={"Default", "login", "register", "reset_password"})
	 * @Assert\Email(groups={"Default", "login", "register", "reset_password"})
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
	 *
	 * @Assert\NotBlank(groups={"login", "register"})
	 */
	protected $plainPassword;
	
	/**
	 * @var string
	 * 
	 * @ORM\Column(type="string", nullable=false)
	 */
	protected $salt;
	
	/**
	 * @var string
	 * 
	 * @ORM\Column(type="text", nullable=false)
	 */
	protected $roles = '';
	
	/**
	 * @var boolean
	 *
	 * @ORM\Column(type="boolean", nullable=false)
	 */
	protected $enabled = true;
	
	/**
	 * @var ArrayCollection|UserConnectionInterface[]
	 *
	 * @ORM\OneToMany(targetEntity=UserConnection::class, mappedBy="user")
	 */
	protected $userConnections;
	
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
		return $this->email;
	}
	
	/**
	 * @return string
	 */
	public function getPassword() {
		return $this->password;
	}
	
	/**
	 * @return string
	 */
	public function getPlainPassword() {
		return $this->plainPassword;
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
		$roles = [];
		if ($this->roles) {
			$roles = explode('|', $this->roles);	
		}
		$roles[] = UserInterface::ROLE_DEFAULT;
		return array_unique($roles);
	}
	
	/**
	 * @return boolean
	 */
	public function isEnabled() {
		return $this->enabled;
	}
	
	/**
	 * @return ArrayCollection|UserConnectionInterface[]
	 */
	public function getUserConnections() {
		return $this->userConnections;
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
	 * @return self
	 */
	public function setEnabled($enabled) {
		$this->enabled = $enabled;
		return $this;
	}
	
	
	/////////
	// Add //
	/////////
	
	/**
	 * @param string $role
	 * @return self 
	 */
	public function addRole($role) {
		$role = strtoupper($role);
		if ($role === UserInterface::ROLE_DEFAULT) {
			return $this;
		}
		$roles = $this->getRoles();
		if (!in_array($role, $roles, true)) {
			$roles[] = $role;
		}
		$this->roles = implode('|', $roles);
		return $this;
	}
	
	/**
	 * @param UserConnectionInterface $userConnection
	 */
	public function addUserConnection(UserConnectionInterface $userConnection) {
		if (!$this->userConnections->contains($userConnection)) {
			$this->userConnections->add($userConnection);
			$userConnection->setUser($this);
		}
		return $this;
	}
	
	
	////////////
	// Remove //
	////////////
	
	/**
	 * @param string $role
	 * @return self
	 */
	public function removeRole($role) {
		$role = strtoupper($role);
		$roles = $this->getRoles();
		if (false !== $key = array_search($role, $roles, true)) {
			unset($roles[$key]);
			$this->setRoles($roles);
		}
		return $this;
	}
	
	/**
	 * @param UserConnectionInterface $userConnection
	 * @return self
	 */
	public function removeUserConnection(UserConnectionInterface $userConnection) {
		if ($this->userConnections->contains($userConnection)) {
			$this->userConnections->removeElement($userConnection);
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
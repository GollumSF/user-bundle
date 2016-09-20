<?php
namespace GollumSF\UserBundle\Security\Token;

use GollumSF\UserBundle\Entity\UserInterface;
use Symfony\Component\Security\Core\Role\Role;
use Symfony\Component\Security\Core\Role\RoleInterface;

/**
 * GollumSFToken
 *
 * @author Damien Duboeuf <smeagolworms4@gmail.com>
 */
class GollumSFToken implements GollumSFTokenInterface {
	
	/**
	 * @var UserInterface
	 */
	private $user = null;
	
	/**
	 * @var int
	 */
	private $userId = null;
	
	/**
	 * @var boolean
	 */
	private $authenticated = true;
	
	/**
	 * @var Role[]
	 */
	private $roles = [];
	
	/**
	 * @var array
	 */
	private $attributes = [];
	
	public function __construct(UserInterface $user) { 
		$this->setUser($user);
	}
	
	/**
	 * Returns a string representation of the Token.
	 *
	 * This is only to be used for debugging purposes.
	 *
	 * @return string
	 */
	public function __toString() {
		$class = get_class($this);
		$class = substr($class, strrpos($class, '\\') + 1);
		
		$roles = array();
		foreach ($this->roles as $role) {
			$roles[] = $role->getRole();
		}
		return sprintf('%s(user="%s", authenticated=%s, roles="%s")', $class, $this->getUsername(), json_encode($this->authenticated), implode(', ', $roles));
	}
	
	/**
	 * Returns a user representation.
	 * @return UserInterface|NULL
	 */
	public function getUser() {
		return $this->user;
	}
	
	/**
	 * Sets a user.
	 *
	 * @param mixed $user
	 */
	public function setUser($user) {
		$this->user = $user;
		$this->userId = $user->getId();
	}
	
	/**
	 * @return int
	 */
	public function getUserId() {
		return $this->userId;
	}
	
	/**
	 * (non-PHPdoc)
	 *
	 * @see \Symfony\Component\Security\Core\Authentication\Token\AbstractToken::serialize()
	 * @return string
	 */
	public function serialize() {
		return serialize([
			$this->userId,
			$this->authenticated,
			$this->attributes,
		]);
	}
	
	/**
	 * (non-PHPdoc)
	 *
	 * @see \Symfony\Component\Security\Core\Authentication\Token\AbstractToken::unserialize()
	 */
	public function unserialize($str) {
		list(
			$this->userId,
			$this->authenticated,
			$this->attributes
		) = unserialize($str);
	}
	
	/**
	 * Returns the user roles.
	 *
	 * @return RoleInterface[] An array of RoleInterface instances.
	 */
	public function getRoles() {
		if (!$this->roles) {
			$user = $this->getUser();
			if ($user) {
				foreach ($user->getRoles() as $role) {
					if (is_string($role)) {
						$role = new Role($role);
					} elseif (!$role instanceof RoleInterface) {
						throw new \InvalidArgumentException(sprintf('$roles must be an array of strings, or RoleInterface instances, but got %s.', gettype($role)));
					}
					$this->roles[] = $role;
				}
			}
		}
		return $this->roles;
	}
	
	/**
	 * Returns the username.
	 *
	 * @return string
	 */
	public function getUsername() {
		if ($this->user instanceof UserInterface) {
			return $this->user->getUsername();
		}
		return (string) $this->user;
	}
	
	/**
	 * Sets the authenticated flag.
	 *
	 * @param bool $authenticated The authenticated flag
	 */
	public function setAuthenticated($authenticated) {
		$this->authenticated = (bool) $authenticated;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function isAuthenticated() {
		return $this->authenticated;
	}
	
	/**
	 * Removes sensitive information from the token.
	 */
	public function eraseCredentials() {
		if ($this->getUser() instanceof UserInterface) {
			$this->getUser()->eraseCredentials();
		}
	}
	
	/**
	 * Returns the token attributes.
	 *
	 * @return array The token attributes
	 */
	public function getAttributes() {
		return $this->attributes;
	}
	
	/**
	 * Sets the token attributes.
	 *
	 * @param array $attributes The token attributes
	 */
	public function setAttributes(array $attributes) {
		$this->attributes = $attributes;
	}
	
	/**
	 * Returns true if the attribute exists.
	 *
	 * @param string $name The attribute name
	 *
	 * @return bool true if the attribute exists, false otherwise
	 */
	public function hasAttribute($name) {
		return array_key_exists($name, $this->attributes);
	}
	
	/**
	 * Returns an attribute value.
	 *
	 * @param string $name The attribute name
	 *
	 * @return mixed The attribute value
	 *
	 * @throws \InvalidArgumentException When attribute doesn't exist for this token
	 */
	public function getAttribute($name) {
		if (!array_key_exists($name, $this->attributes)) {
			throw new \InvalidArgumentException(sprintf('This token has no "%s" attribute.', $name));
		}
		
		return $this->attributes[$name];
	}
	
	/**
	 * Sets an attribute.
	 *
	 * @param string $name  The attribute name
	 * @param mixed  $value The attribute value
	 */
	public function setAttribute($name, $value) {
		$this->attributes[$name] = $value;
	}
	
	/**
	 * Returns the user credentials.
	 *
	 * @return mixed The user credentials
	 */
	public function getCredentials() {
		return '';
	}
}
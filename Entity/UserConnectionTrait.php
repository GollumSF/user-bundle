<?php
namespace GollumSF\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * UserConnectionTrait
 *
 * @author Damien Duboeuf <smeagolworms4@gmail.com>
 */
trait UserConnectionTrait {
	
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
	 * @ORM\Column(type="string", length=50, nullable=false)
	 */
	protected $provider;
	
	/**
	 * @var string
	 * @ORM\Column(type="string", nullable=false)
	 */
	protected $providerId;
	
	/**
	 * @var User
	 *
	 * @ORM\ManyToOne(targetEntity=User::class, inversedBy="userTokens", cascade={"persist"})
	 * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
	 */
	protected $user;
	
	/**
	 * @var boolean
	 * @ORM\Column(type="boolean", nullable=false)
	 */
	protected $confirmed = true;
	
	
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
	public function getProvider() {
		return $this->provider;
	}
	
	/**
	 * @return string
	 */
	public function getProviderId() {
		return $this->providerId;
	}
	
	/**
	 * @return UserInterface
	 */
	public function getUser() {
		return $this->user;
	}
	
	/**
	 * @return boolean
	 */
	public function isConfirmed() {
		return $this->confirmed;
	}
	
	
	/////////////
	// Setters //
	/////////////
	
	/**
	 * @param string $provider
	 * @return self
	 */
	public function setProvider($provider) {
		$this->provider = $provider;
		return $this;
	}
	
	/**
	 * @param string $providerId
	 * @return self
	 */
	public function setProviderId($providerId) {
		$this->providerId = $providerId;
		return $this;
	}
	
	/**
	 * @param UserInterface $user
	 * @return self
	 */
	public function setUser(UserInterface $user) {
		$this->user = $user;
		return $this;
	}
	
	/**
	 * @param boolean $confirmed
	 * @return self
	 */
	public function setConfirmed($confirmed) {
		$this->confirmed = $confirmed;
		return $this;
	}
	
}
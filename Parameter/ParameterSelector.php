<?php
namespace GollumSF\UserBundle\Parameter;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * ParameterSelector
 *
 * @author Damien Duboeuf <smeagolworms4@gmail.com>
 */
class ParameterSelector {
	
	/**
	 * @var ContainerInterface
	 */
	private $container;
	
	/**
	 * @var string
	 */
	private $baseName;
	
	/**
	 * @var string
	 */
	private $prefix;
	
	public function __construct(ContainerInterface $container, $baseName, $prefix = '') {
		$this->container = $container;
		$this->baseName  = $baseName;
		$this->prefix    = $prefix;
	}
	
	/**
	 * Return the parameter value
	 * @param string $key
	 * @return mixed
	 */
	public function get($key) {
		return $this->prefix.$this->container->getParameter($this->baseName.'.'.$key);
	}
	
}
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
	
	public function __construct(ContainerInterface $container, $baseName) {
		$this->container = $container;
		$this->baseName  = $baseName;
	}
	
	/**
	 * Return the parameter value
	 * @param string $key
	 * @return mixed
	 */
	public function get($key) {
		return $this->container->getParameter($this->baseName.'.'.$key);
	}
	
}
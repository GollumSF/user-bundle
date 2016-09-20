<?php
namespace GollumSF\UserBundle\DependencyInjection\Security\Factory;

use Symfony\Bundle\SecurityBundle\DependencyInjection\Security\Factory\SecurityFactoryInterface;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\DependencyInjection\Reference;

/**
 * GollumSFFactory
 *
 * @author Damien Duboeuf <smeagolworms4@gmail.com>
 */
class GollumSFFactory implements SecurityFactoryInterface {
	
	public function create(ContainerBuilder $container, $id, $config, $userProvider, $defaultEntryPoint) {
		
		$providerId = 'security.authentication.provider.gsf_user.'.$id;
		$container->setDefinition($providerId, new DefinitionDecorator('gsf_user.security.authentication_provider'));
		
		$listenerId = 'security.authentication.listener.gsf_user.'.$id;
		$container->setDefinition($listenerId, new DefinitionDecorator('gsf_user.security.authentication_listener'));
		
		return [ $providerId, $listenerId, $defaultEntryPoint];
	}
	
	public function getPosition() {
		return 'pre_auth';
	}
	
	public function getKey() {
		return 'gsf_user';
	}
	
	public function addConfiguration(NodeDefinition $builder) {
	}
}
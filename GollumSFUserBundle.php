<?php
namespace GollumSF\UserBundle;

use GollumSF\UserBundle\DependencyInjection\Security\Factory\GollumSFFactory;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * GollumSFCoreBundle
 *
 * @author Damien Duboeuf <smeagolworms4@gmail.com>
 */
class GollumSFUserBundle extends Bundle {
	
	public function build(ContainerBuilder $container) {
		parent::build($container);
		$extension = $container->getExtension('security');
		$extension->addSecurityListenerFactory(new GollumSFFactory());
	}
		
}

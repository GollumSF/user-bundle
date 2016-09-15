<?php
namespace GollumSF\RestBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface {
	
	public function getConfigTreeBuilder() {
		
		$treeBuilder = new TreeBuilder();;
		$rootNode = $treeBuilder->root('gollum_sf_rest');
		
		$rootNode
			->children()
				->arrayNode('format')
					->requiresAtLeastOneElement()
					->defaultValue(['json', 'xml'])
					->prototype('scalar')->end()
				->end()
				->arrayNode('schemes')
					->requiresAtLeastOneElement()
					->defaultValue(['http', 'https'])
					->prototype('scalar')->end()
				->end()
				->booleanNode('overrideUrlExtension')
					->defaultValue(true)
				->end()
				->scalarNode('defaultFormat')
					->defaultValue('json')
				->end()
			->end()
		;
		
		return $treeBuilder;
	}
}

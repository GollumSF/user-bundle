<?php
namespace GollumSF\UserBundle\DependencyInjection;

use GollumSF\UserBundle\Entity\User;
use GollumSF\UserBundle\Entity\UserConnection;
use GollumSF\UserBundle\Form\LoginType;
use GollumSF\UserBundle\Form\RegisterType;
use GollumSF\UserBundle\Form\ResetPasswordType;
use GollumSF\UserBundle\Manager\UserConnectionManager;
use GollumSF\UserBundle\Manager\UserManager;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface {
	
	public function getConfigTreeBuilder() {
		
		$treeBuilder = new TreeBuilder();;
		$rootNode = $treeBuilder->root('gollum_sf_user');
		
		$rootNode
			->children()
				->append($this->addUserNode())
				->append($this->addUserConnectionNode())
				->append($this->addTwigNode())
				->append($this->addFormNode())
				->append($this->addUrlNode())
			->end()
		;
		
		return $treeBuilder;
	}
	
	public function addUserNode() {
		$builder = new TreeBuilder();
		$node = $builder->root('user');
		
		$node
			->addDefaultsIfNotSet()
			->children()
				->scalarNode('entity')->defaultValue(User::class)->end()
				->scalarNode('manager')->defaultValue(UserManager::class)->end()
			->end()
		;
		
		return $node;
	}
	
	public function addUserConnectionNode() {
		$builder = new TreeBuilder();
		$node = $builder->root('user_connection');
		
		$node
			->addDefaultsIfNotSet()
			->children()
				->scalarNode('entity')->defaultValue(UserConnection::class)->end()
				->scalarNode('manager')->defaultValue(UserConnectionManager::class)->end()
			->end()
		;
		
		return $node;
	}
	
	public function addTwigNode() {
		$builder = new TreeBuilder();
		$node = $builder->root('twig');
		
		$node
			->addDefaultsIfNotSet()
			->children()
				->scalarNode('base')          ->defaultValue('::base.html.twig')                               ->end()
				->scalarNode('base_auth')     ->defaultValue('GollumSFUserBundle:Auth:base.html.twig')         ->end()
				->scalarNode('login')         ->defaultValue('GollumSFUserBundle:Auth:login.html.twig')        ->end()
				->scalarNode('register')      ->defaultValue('GollumSFUserBundle:Auth:register.html.twig')     ->end()
				->scalarNode('reset_password')->defaultValue('GollumSFUserBundle:Auth:resetPassword.html.twig')->end()
			->end()
		;
		
		return $node;
	}
	
	public function addFormNode() {
		$builder = new TreeBuilder();
		$node = $builder->root('form');
		
		$node
			->addDefaultsIfNotSet()
			->children()
				->scalarNode('login')         ->defaultValue(LoginType::class)        ->end()
				->scalarNode('register')      ->defaultValue(RegisterType::class)     ->end()
				->scalarNode('reset_password')->defaultValue(ResetPasswordType::class)->end()
			->end()
		;
		
		return $node;
	}
	
	public function addUrlNode() {
		$builder = new TreeBuilder();
		$node = $builder->root('url');
		
		$node
			->addDefaultsIfNotSet()
			->children()
				->scalarNode('homepage')      ->defaultValue('/')              ->end()
				->scalarNode('login')         ->defaultValue('/login')         ->end()
				->scalarNode('register')      ->defaultValue('/register')      ->end()
				->scalarNode('reset_password')->defaultValue('/reset-password')->end()
			->end()
		;
		
		return $node;
	}
}

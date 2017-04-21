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
				->append($this->addEntitiesNode())
				->append($this->addTwigNode())
				->append($this->addFormNode())
				->append($this->addUrlNode())
			->end()
		;
		
		return $treeBuilder;
	}
	
	
	public function addEntitiesNode() {
		$builder = new TreeBuilder();
		$node = $builder->root('entities');
		
		$node
			->addDefaultsIfNotSet()
			->children()
				->append($this->addUserNode())
				->append($this->addUserConnectionNode())
			->end()
		;
		
		return $node;
	}
	
	public function addUserNode() {
		$builder = new TreeBuilder();
		$node = $builder->root('user');
		
		$node
			->addDefaultsIfNotSet()
			->children()
				->scalarNode('class')->defaultValue(User::class)->end()
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
				->scalarNode('class')->defaultValue(UserConnection::class)->end()
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
				->scalarNode('base')                   ->defaultValue('::base.html.twig')                                           ->end()
				->scalarNode('base_auth')              ->defaultValue('GollumSFUserBundle:Auth:base.html.twig')                     ->end()
				->scalarNode('login')                  ->defaultValue('GollumSFUserBundle:Auth:login.html.twig')                    ->end()
				->scalarNode('register')               ->defaultValue('GollumSFUserBundle:Auth:register.html.twig')                 ->end()
				->scalarNode('reset_password')         ->defaultValue('GollumSFUserBundle:Auth:resetPassword.html.twig')            ->end()
				->scalarNode('base_mail_html')         ->defaultValue('GollumSFUserBundle:Mail:baseMail.html.twig')                ->end()
				->scalarNode('base_mail_txt')          ->defaultValue('GollumSFUserBundle:Mail:baseMail.txt.twig')                 ->end()
				->scalarNode('mail_confirm_email_html')->defaultValue('GollumSFUserBundle:Mail:confirmEmail/confirmEmail.html.twig')->end()
				->scalarNode('mail_confirm_email_txt') ->defaultValue('GollumSFUserBundle:Mail:confirmEmail/confirmEmail.txt.twig') ->end()
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
				->scalarNode('prefix')        ->defaultValue('')               ->end()
				->scalarNode('homepage')      ->defaultValue('/')              ->end()
				->scalarNode('login')         ->defaultValue('/login')         ->end()
				->scalarNode('logout')        ->defaultValue('/logout')        ->end()
				->scalarNode('register')      ->defaultValue('/register')      ->end()
				->scalarNode('reset_password')->defaultValue('/reset-password')->end()
				->scalarNode('confirm_email') ->defaultValue('/confirm-email') ->end()
			->end()
		;
		
		return $node;
	}
}

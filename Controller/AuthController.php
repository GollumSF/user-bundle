<?php
namespace GollumSF\UserBundle\Controller;

use GollumSF\CoreBundle\Controller\CoreAbstractController;
use GollumSF\UserBundle\Parameter\ParameterSelector;
use Redori\UserBundle\Manager\UserManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;

/**
 * AuthController
 * @author Damien Duboeuf <smeagolworms4@gmail.com>
 */
class AuthController extends CoreAbstractController {
	
	/**
	 * @var UserManager
	 */
	private $userManager;
	
	/**
	 * @var ParameterSelector
	 */
	private $formSelector;
	
	/**
	 * @var ParameterSelector
	 */
	private $twigSelector;
	
	
	public function setContainer(ContainerInterface $container = null) {
		parent::setContainer($container);
		$this->userManager  = $this->get('gsf_user.manager.user');
		$this->formSelector = $this->get('gsf_user.parameter.twig_selector');
		$this->twigSelector = $this->get('gsf_user.parameter.form_selector');
	}
	
	/**
	 * @Route("/login")
	 * @Method({"GET", "POST"})
	 */
	public function loginAction(Request $request) {
		
		$user = $this->userManager->createUser();
		$form = $this->createForm($this->getForm('login'), $user);
		
		if ($request->isMethod('POST')) {
			$form->handleRequest($request);
			if ($form->isValid()) {
				
				$userDB = $this->userManager->findOneEnabledByEmail($user->getEmail());
				if ($userDB) {
					
					// TODO Log User
					
					return $this->redirect($request->get('redirect') ? $request->get('redirect') : $this->getHomepage());
					
				} else {
					$translator = $this->get('translator');
					$error = $translator->trans('gsf_user.user.emailNotFound', [], 'validators');
					$form->addError(new FormError($error));
				}
			}
		}
		
		return $this->render($this->getTwig('login'), [
			'base'      => $this->getTwig('base'),
			'base_auth' => $this->getTwig('base_auth'),
			'form'      => $form->createView(),
		]);
	}
	
	/**
	 * @Route("/register")
	 * @Method({"GET", "POST"})
	 */
	public function registerAction(Request $request) {
		$user = $this->userManager->createUser();
		$form = $this->createForm($this->getForm('register'), $user);
		
		if ($request->isMethod('POST')) {
			$form->handleRequest($request);
			if ($form->isValid()) {
				
				// TODO SET User in BDD
				
				return $this->redirect($request->get('redirect') ? $request->get('redirect') : $this->getHomepage());
			}
		}
		
		return $this->render($this->getTwig('register'), [
			'base'      => $this->getTwig('base'),
			'base_auth' => $this->getTwig('base_auth'),
			'form'      => $form->createView(),
		]);
	}
	
	/**
	 * @Route("/reset-password")
	 * @Method({"GET", "POST"})
	 */
	public function resetPasswordAction(Request $request) {
		$user = $this->userManager->createUser();
		$form = $this->createForm($this->getForm('reset_password'), $user);
		
		if ($request->isMethod('POST')) {
			$form->handleRequest($request);
			if ($form->isValid()) {
				
				// TODO Send Email reset password
				
				return $this->redirect($request->get('redirect') ? $request->get('redirect') : $this->getHomepage());
			}
		}
		
		return $this->render($this->getTwig('reset_password'), [
			'base'      => $this->getTwig('base'),
			'base_auth' => $this->getTwig('base_auth'),
			'form'      => $form->createView(),
		]);
	}
	
	/**
	 * @param $key
	 * @return string
	 */
	protected function getForm($key) {
		return $this->formSelector->get($key);
	}
	
	/**
	 * @param $key
	 * @return string
	 */
	protected function getTwig($key) {
		return $this->twigSelector->get($key);
	}
	
	/**
	 * @return string
	 */
	protected function getHomepage() {
		$request = $this->getRequest();
		$url = $this->container->getParameter('gsf_user.configurations.homepage');
		if (
			strpos($url, '//') !== 0 &&
			!filter_var($url, FILTER_VALIDATE_URL)
		) {
			$url = $request->getBasePath().$url;
		}
		return $url;
	}
}
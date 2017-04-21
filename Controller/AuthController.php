<?php
namespace GollumSF\UserBundle\Controller;

use GollumSF\CoreBundle\Controller\CoreAbstractController;
use GollumSF\UserBundle\Authenticator\AuthenticatorInterface;
use GollumSF\UserBundle\Confirm\ConfirmMail;
use GollumSF\UserBundle\Manager\UserManagerInterface;
use GollumSF\UserBundle\Parameter\ParameterSelector;
use GollumSF\UserBundle\Parameter\UrlParameterSelector;
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
	 * @var UserManagerInterface
	 */
	private $userManager;
	
	/**
	 * @var AuthenticatorInterface
	 */
	private $authenticator;
	
	/**
	 * @var ParameterSelector
	 */
	private $formSelector;
	
	/**
	 * @var ParameterSelector
	 */
	private $twigSelector;
	
	/**
	 * @var UrlParameterSelector
	 */
	private $urlSelector;
	
	
	public function setContainer(ContainerInterface $container = null) {
		parent::setContainer($container);
		$this->userManager   = $this->get('gsf_user.manager.user');
		$this->authenticator = $this->get('gsf_user.authenticator');
		$this->formSelector  = $this->get('gsf_user.parameter.twig_selector');
		$this->twigSelector  = $this->get('gsf_user.parameter.form_selector');
		$this->urlSelector   = $this->get('gsf_user.parameter.url_selector');
	}
	
	/**
	 * @Route("/login")
	 * @Method({"GET", "POST"})
	 */
	public function loginAction(Request $request) {
		
		$user           = $this->userManager->createUser();
		$form           = $this->createForm($this->getForm('login'), $user, [ 'validation_groups' => ['login'] ]);
		$redirect       = $request->get('redirect');
		$redirectParams = $redirect ? [ 'redirect' => $redirect ] : [];
		
		if ($request->isMethod('POST')) {
			$form->handleRequest($request);
			if ($form->isValid()) {
				
				$userDB = $this->userManager->findOneEnabledByEmail($user->getEmail());
				if ($userDB) {
					
					$user = $this->userManager->register($userDB);
					
					if ($this->authenticator->authenticate($user)) {
						return $this->redirect($redirect ? $redirect : $this->getUrl('homepage'));
					}
					
				} else {
					$translator = $this->get('translator');
					$error = $translator->trans('gsf_user.user.emailNotFound', [], 'validators');
					$form->addError(new FormError($error));
				}
			}
		}
		
		return $this->render($this->getTwig('login'), [
			'base'           => $this->getTwig('base'),
			'base_auth'      => $this->getTwig('base_auth'),
			'form'           => $form->createView(),
			'register'       => $this->getUrl('register', $redirectParams),
			'reset_password' => $this->getUrl('reset_password', $redirectParams),
		]);
	}
	
	/**
	 * @Route("/register")
	 * @Method({"GET", "POST"})
	 */
	public function registerAction(Request $request) {
		
		$user     = $this->userManager->createUser();
		$form     = $this->createForm($this->getForm('register'), $user, [ 'validation_groups' => ['register'] ]);
		$redirect = $request->get('redirect');
		$redirectParams = $redirect ? [ 'redirect' => $redirect ] : [];
		
		if ($request->isMethod('POST')) {
			$form->handleRequest($request);
			if ($form->isValid()) {
				
				$user = $this->userManager->register($user);
				if ($this->authenticator->authenticate($user)) {
					return $this->redirect($redirect ? $redirect : $this->getUrl('homepage'));
				}
			}
		}
		
		return $this->render($this->getTwig('register'), [
			'base'           => $this->getTwig('base'),
			'base_auth'      => $this->getTwig('base_auth'),
			'form'           => $form->createView(),
			'login'          => $this->getUrl('login', $redirectParams),
			'reset_password' => $this->getUrl('reset_password', $redirectParams),
		]);
	}
	
	/**
	 * @Route("/logout")
	 * @Method("GET")
	 */
	public function logoutAction(Request $request) {
		
		$redirect = $request->get('redirect');
		
		if ($this->authenticator->logout()) {
			return $this->redirect($redirect ? $redirect : $this->getUrl('login'));
		}
		return $this->redirect($redirect ? $redirect : $this->getUrl('homepage'));
	}
	
	/**
	 * @Route("/confirm-email")
	 * @Method("GET")
	 */
	public function confirmEmailAction(Request $request) {
		
		/** @var ConfirmMail $confirmMail */
		$confirmMail = $this->get('gsf_user.confirm.mail');
		$email = $confirmMail->validateRequest($request);
		
		return $this->render($this->getTwig('confirm_mail'), [
			'base_auth' => $this->getTwig('base_auth'),
			'base'      => $this->getTwig('base'),
			'homepage'  => $this->getUrl('homepage'),
		]);
	}
	
	/**
	 * @Route("/reset-password")
	 * @Method({"GET", "POST"})
	 */
	public function resetPasswordAction(Request $request) {
		
		$user     = $this->userManager->createUser();
		$form     = $this->createForm($this->getForm('reset_password'), $user, [ 'validation_groups' => ['reset_password'] ]);
		$redirect = $request->get('redirect');
		$redirectParams = $redirect ? [ 'redirect' => $redirect ] : [];
		
		if ($request->isMethod('POST')) {
			$form->handleRequest($request);
			if ($form->isValid()) {
				
				// TODO Send Email reset password
				
				return $this->redirect($this->getUrl('login', $redirectParams));
			}
		}
		
		return $this->render($this->getTwig('reset_password'), [
			'base'      => $this->getTwig('base'),
			'base_auth' => $this->getTwig('base_auth'),
			'form'      => $form->createView(),
			'login'     => $this->getUrl('login', $redirectParams),
			'register'  => $this->getUrl('register', $redirectParams),
		]);
	}
	
	/**
	 * @param string $key
	 * @return string
	 */
	protected function getForm($key) {
		return $this->formSelector->get($key);
	}
	
	/**
	 * @param string $key
	 * @return string
	 */
	protected function getTwig($key) {
		return $this->twigSelector->get($key);
	}
	
	/**
	 * @param $key
	 * @param array $params
	 * @param int $mode
	 * @return string
	 */
	protected function getUrl($key, $params = [], $mode) {
		return  $this->urlSelector->get($key, $params, $mode);
	}
}
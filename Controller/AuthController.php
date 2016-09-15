<?php
namespace GollumSF\AuthRestBundle\Controller;

use GollumSF\AuthRestBundle\Form\LoginType;
use GollumSF\AuthRestBundle\Form\RegisterType;
use GollumSF\AuthRestBundle\Form\ResetPasswordType;
use GollumSF\AuthRestBundle\Manager\UserManager;
use GollumSF\CoreBundle\Controller\CoreAbstractController;
use GollumSF\RestBundle\Annotation\Rest;
use GollumSF\RestBundle\Response\RestResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;

/**
 * AuthController
 * @author Damien Duboeuf <smeagolworms4@gmail.com>
 * 
 * @Route("/auth")
 */
class AuthController extends CoreAbstractController {
	
	/**
	 * @var UserManager
	 */
	private $userManager;
	
	public function setContainer(ContainerInterface $container = null) {
		parent::setContainer($container);
		$this->userManager = $this->get('gsf_auth_rest.user_manager');
	}
	
	/**
	 * @Route("/login")
	 * @Method({"GET", "POST"})
	 * @Rest
	 */
	public function loginAction(Request $request) {
		
		$user = $this->userManager->createUser();
		$form = $this->createForm(LoginType::class, $user);
		
		if ($request->isMethod('POST')) {
			$form->handleRequest($request);
			if ($form->isValid()) {
				
				$userDB = $this->userManager->findOneEnabledByEmail($user->getEmail());
				if ($userDB) {
					
					return $userDB;
				} else {
					$form->addError(new FormError('gsf_auth_rest.user.emailNotFound'));
				}
			}
			return new RestResponse($this->formErrors($form), 400);
		}
		return $this->formDescribe($form);
	}
	
	/**
	 * @Route("/register")
	 * @Method({"GET", "POST"})
	 * @Rest
	 */
	public function registerAction(Request $request) {
		$user = $this->userManager->createUser();
		$form = $this->createForm(RegisterType::class, $user);
		
		if ($request->isMethod('POST')) {
			$form->handleRequest($request);
			if ($form->isValid()) {
				
				// TODO SET User in BDD
				
				return $user;
			}
			return new RestResponse($this->formErrors($form), 400);
		}
		
		return $this->formDescribe($form);
	}
	
	/**
	 * @Route("/reset-password")
	 * @Method({"GET", "POST"})
	 * @Rest
	 */
	public function resetPasswordAction(Request $request) {
		$user = $this->userManager->createUser();
		$form = $this->createForm(ResetPasswordType::class, $user);
		
		if ($request->isMethod('POST')) {
			$form->handleRequest($request);
			if ($form->isValid()) {
				
				// TODO Send Email reset password
				
				return $user;
			}
			return new RestResponse($this->formErrors($form), 400);
		}
		
		return $this->formDescribe($form);
	}
	
}
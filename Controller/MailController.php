<?php
namespace GollumSF\UserBundle\Controller;

use GollumSF\CoreBundle\Controller\CoreAbstractController;
use GollumSF\UserBundle\Manager\UserManagerInterface;
use GollumSF\UserBundle\Parameter\ParameterSelector;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * EmailController
 * @author Damien Duboeuf <smeagolworms4@gmail.com>
 */
class MailController extends CoreAbstractController {
	
	/**
	 * @var UserManagerInterface
	 */
	private $userManager;
	
	/**
	 * @var ParameterSelector
	 */
	private $twigSelector;
	
	/**
	 * @var ParameterSelector
	 */
	private $urlSelector;
	
	
	public function setContainer(ContainerInterface $container = null) {
		parent::setContainer($container);
		$this->userManager  = $this->get('gsf_user.manager.user');
		$this->twigSelector = $this->get('gsf_user.parameter.form_selector');
		$this->urlSelector  = $this->get('gsf_user.parameter.url_selector');
	}
	
	public function confirmEmailAction(Request $request) {
		
		return $this->render($this->getTwig('mail_confirm_email'), [
			'base_mail' => $this->getTwig('base_mail'),
		]);
	}
	
	/**
	 * @param $key
	 * @return string
	 */
	protected function getTwig($key) {
		return $this->twigSelector->get($key);
	}
	
}
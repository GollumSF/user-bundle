<?php
namespace GollumSF\UserBundle\Controller;

use GollumSF\CoreBundle\Controller\CoreAbstractController;
use GollumSF\UserBundle\Entity\UserConnection;
use GollumSF\UserBundle\Manager\UserManagerInterface;
use GollumSF\UserBundle\Parameter\ParameterSelector;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * EmailController
 * @author Damien Duboeuf <smeagolworms4@gmail.com>
 */
class MailController extends CoreAbstractController {
	
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
	
	/**
	 * @param Request $request
	 * @param UserConnection $userConnection
	 * @return Response
	 */
	public function confirmEmailAction(Request $request, UserConnection $userConnection) {
		
		/**
		 * @var \Twig_Environment $twig
		 */
		$twig = $this->get('twig');
		
		return $this->render($this->getTwig('mail_confirm_email_body'), [
			'base_mail'      => $this->getTwig('base_mail'),
			'userConnection' => $this->getTwig('$userConnection'),
		],
		[
			'Mail-Subject' => 'gsf_user.mail.confirm_email.subject',
			'Mail-Text'    => $twig->render($this->getTwig('mail_confirm_email_text'), [
				'userConnection' => $this->getTwig('$userConnection'),
			]),
		]);
	}
	
	/**
	 * @param $key
	 * @return string
	 */
	protected function getTwig($key) {
		return $this->twigSelector->get($key);
	}
	
	/**
	 * @param $key
	 * @return string
	 */
	protected function getUrl($key) {
		return $this->urlSelector->get($key);
	}
	
}
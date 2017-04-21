<?php
namespace GollumSF\UserBundle\Controller;

use GollumSF\CoreBundle\Controller\CoreAbstractController;
use GollumSF\EmailBundle\Builder\EmailBuilder;
use GollumSF\UserBundle\Confirm\ConfirmMail;
use GollumSF\UserBundle\Entity\UserConnection;
use GollumSF\UserBundle\Parameter\ParameterSelector;
use GollumSF\UserBundle\Parameter\UrlParameterSelector;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Translation\TranslatorInterface;

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
	 * @var UrlParameterSelector
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
		 * @var \Twig_Environment   $twig
		 * @var TranslatorInterface $translator
		 * @var ConfirmMail         $confirmMail
		 */
		$twig        = $this->get('twig');
		$translator  = $this->get('translator');
		$confirmMail = $this->get('gsf_user.confirm.mail');
		
		$subject    = $translator->trans('gsf_user.mail.confirm_email.subject');
		$confirmUrl = $confirmMail->generateUrlByUserConnection($userConnection);
		
		$params = [
			'base_html'      => $this->getTwig('base_mail_html'),
			'base_txt'       => $this->getTwig('base_mail_txt'),
			'subject'        => $subject,
			'userConnection' => $userConnection,
			'confirmUrl'     => $confirmUrl,
		];
		
		return $this->render($this->getTwig('mail_confirm_email_html'), $params, new Response('', Response::HTTP_OK, [
			EmailBuilder::HEADER_SUBJECT  => $subject,
			EmailBuilder::HEADER_ALT_TEXT => $twig->render($this->getTwig('mail_confirm_email_txt'), $params),
		]));
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
	 * @param array $params
	 * @param int $mode
	 * @return string
	 */
	protected function getUrl($key, $params = [], $mode) {
		return  $this->urlSelector->get($key, $params, $mode);
	}
	
}
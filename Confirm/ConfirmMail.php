<?php
namespace GollumSF\UserBundle\Confirm;
use GollumSF\UrlTokenizerBundle\Checker\CheckerInterface;
use GollumSF\UrlTokenizerBundle\Tokenizer\TokenizerInterface;
use GollumSF\UserBundle\Entity\UserConnection;
use GollumSF\UserBundle\Parameter\UrlParameterSelector;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\RouterInterface;

/**
 * ConfirmMail
 *
 * @author Damien Duboeuf <damien@swabbl.com>
 */
class ConfirmMail {
	
	const TOKEN_ACTION_NAME = 'confirm_email';
	
	/**
	 * @var TokenizerInterface
	 */
	private $tokenizer;
	
	/**
	 * @var CheckerInterface
	 */
	private $checker;
	
	/**
	 * @var UrlParameterSelector
	 */
	private $urlSelector;
	
	public function __construct(
		TokenizerInterface $tokenizer,
		CheckerInterface $checker,
		UrlParameterSelector $urlSelector
	) {
		$this->tokenizer   = $tokenizer;
		$this->checker     = $checker;
		$this->urlSelector = $urlSelector;
	}
	
	/**
	 * @param UserConnection $userConnection
	 * @return string
	 */
	public function generateUrlByUserConnection(UserConnection $userConnection) {
		return $this->generateUrl($userConnection->getProviderId());
	}
	
	/**
	 * @param string $mail
	 * @return string
	 */
	public function generateUrl($mail) {
		return $this->tokenizer->generateUrl(
			$this->getUrl('confirm_email', [
				'd' => time(),
				'e' => $mail,
				'a' => self::TOKEN_ACTION_NAME,
			], RouterInterface::ABSOLUTE_URL)
		);
	}
	
	/**
	 * @param Request $request
	 * @return string
	 * @throws BadRequestHttpException
	 */
	public function validateRequest(Request $request) {
		$action = $request->get('a');
		$email  = $request->get('e');
		$date   = $request->get('d');
		$token  = $request->get('t');
		if (!$email || !$date || !$token || !$action || $action != self::TOKEN_ACTION_NAME) {
			new BadRequestHttpException('Query string a, d, e or t not found or not valid');
		}
		
		if ($this->validateUrl($request->getRequestUri(), $date)) {
			return $email;
		}
		return false;
	}
	
	/**
	 * @param string $url
	 * @param int    $date
	 * @return boolean
	 */
	public function validateUrl($url, $date) {
		
		// TODO  Check date expired;
		
		return $this->checker->checkToken($url);
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
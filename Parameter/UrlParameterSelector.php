<?php
namespace GollumSF\UserBundle\Parameter;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\RouterInterface;

/**
 * UrlParameterSelector
 *
 * @author Damien Duboeuf <smeagolworms4@gmail.com>
 */
class UrlParameterSelector extends ParameterSelector {
	
	/**
	 * @var RequestStack
	 */
	private $requestStack;
	
	public function setRequestStack(RequestStack $requestStack) {
		$this->requestStack = $requestStack;
	}
	
	/**
	 * @return Request
	 */
	protected function getMasterRequest() {
		return $this->requestStack->getMasterRequest();
	}
	
	/**
	 * Return the parameter value
	 * @param string $key
	 * @param [] $params
	 * @return string
	 */
	public function get($key) {
		$params = [];
		$args = func_get_args();
		if (isset($args[1]) && is_array($args[1])) {
			$params = $args[1];
		}
		$mode = RouterInterface::ABSOLUTE_PATH;
		if (isset($args[2])) {
			$mode = $args[2];
		}
		
		$request = $this->getMasterRequest();
		$url = parent::get($key);
		if ($mode == RouterInterface::ABSOLUTE_URL) {
			$url = $request->getUriForPath($url);
		} else {
			$url = $request->getBaseUrl().$url;
		}
		
		if ($params) {
			$query = http_build_query($params);// Returns a string if the URL has parameters or NULL if not
			$url .= (parse_url($url, PHP_URL_QUERY) ? '&' : '?').$query;
		}
		return $url;
	}
	
}
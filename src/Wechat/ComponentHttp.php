<?php namespace Gibson\Wechat;

class ComponentHttp extends HttpClient
{
	/**
	 * constructor
	 *
	 * @param ComponentAccessToken $token
	 */
	public function __construct($token = null)
	{
		if(!$token) {
			$token = new ComponentAccessToken();
		}

		$this->token = $token instanceof ComponentAccessToken ? $token->getToken() : $token;
		parent::__construct();
	}
}

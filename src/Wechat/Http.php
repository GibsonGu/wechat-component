<?php namespace Gibson\Wechat;

class Http extends HttpClient
{
	public function __construct($token = null)
	{
//		if(!$token) {
//			$token = new AccessToken();
//		}

		$this->authorizer_access_token = $token;
		parent::__construct();
	}
}

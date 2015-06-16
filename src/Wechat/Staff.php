<?php namespace Gibson\Wechat;

/**
 * 客服
 */
class Staff extends \Overtrue\Wechat\Staff
{
	/**
	 * @param string $authorizer_appid
	 * @param string $authorizer_refresh_token
	 */
	public function __construct($authorizer_appid, $authorizer_refresh_token)
	{
		$this->http = new Http(new AccessToken($authorizer_appid, $authorizer_refresh_token));
	}
}

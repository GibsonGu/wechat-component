<?php namespace Gibson\Wechat;

/**
 * 客服
 */
class Staff extends \Overtrue\Wechat\Staff
{
	/**
	 * @param string|AccessToken $accessToken
	 */
	public function __construct($accessToken)
	{
		$this->http = new Http($accessToken);
	}
}

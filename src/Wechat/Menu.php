<?php namespace Gibson\Wechat;

/**
 * 自定义菜单
 */
class Menu extends \Overtrue\Wechat\Menu
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

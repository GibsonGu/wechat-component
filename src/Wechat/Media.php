<?php namespace Gibson\Wechat;

/**
 * 媒体素材
 */
class Media extends \Overtrue\Wechat\Media
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

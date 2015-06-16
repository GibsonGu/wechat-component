<?php namespace Gibson\Wechat;

/**
 * 全局通用 ComponentAccessToken
 */
class ComponentAccessToken
{
	protected $token;

	protected $cacheKey = 'gibson.wechat.component_access_token';

	const API_AUTHORIZER_TOKEN = 'https:// api.weixin.qq.com/cgi-bin/component/api_authorizer_token';

	public function __construct($force = false)
	{
		$this->force = $force;
	}

	/**
	 * 获取Token
	 *
	 * @return string
	 */
	public function getToken()
	{
		$this->token = \Cache::get($this->cacheKey);

		// 从缓存中获取不到token或设置了强制刷新
		if(!$this->token || $this->force)
		{
			$params = array(
				'component_appid' => \Config::get('wechat:component_appid'),
				'authorizer_appid' => \Config::get('wechat:component_appsecret'),
				'authorizer_refresh_token' => ComponentVerifyTicket::getTicket(),
			);

			$http = new ComponentHttp();
			$response = $http->jsonPost(self::API_AUTHORIZER_TOKEN, $params);

			// 设置token
			$this->token = $response['component_access_token'];

			// 把token缓存起来
			$expiresAt = \Carbon::now()->addSeconds($response['expires_in']);
			\Cache::put($this->cacheKey, $this->token, $expiresAt);
		}

		return $this->token;
	}
}

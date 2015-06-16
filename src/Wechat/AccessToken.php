<?php namespace Gibson\Wechat;

/**
 * 全局通用 AccessToken
 */
class AccessToken
{
	/**
	 * 授权方令牌
	 *
	 * @var string
	 */
	protected $token;

	/**
	 * 授权方appid
	 *
	 * @var string
	 */
	protected $authorizer_appid;

	/**
	 * 授权方的刷新令牌
	 *
	 * @var string
	 */
	protected $authorizer_refresh_token;

	/**
	 * 缓存前缀
	 *
	 * @var string
	 */
	protected $cacheKey = 'gibson.wechat.authorizer_access_token.%s';

	const API_AUTHORIZER_TOKEN = 'https:// api.weixin.qq.com/cgi-bin/component/api_authorizer_token';

	public function __construct($authorizer_appid, $authorizer_refresh_token)
	{
		$this->authorizer_appid = $authorizer_appid;
		$this->authorizer_refresh_token = $authorizer_refresh_token;
	}

	/**
	 * 获取授权公众号的令牌
	 *
	 * @return string
	 */
	public function getToken()
	{
		$this->token = \Cache::get(sprintf($this->cacheKey, $this->authorizer_appid));

		// 从缓存中获取不到token
		if(!$this->token)
		{
			$params = array(
					'component_appid' => \Config::get('wechat::appid'),
					'authorizer_appid' => $this->authorizer_appid,
					'authorizer_refresh_token' => $this->authorizer_refresh_token,
			);

			$http = new ComponentHttp();
			$response = $http->jsonPost(self::API_AUTHORIZER_TOKEN, $params);

			// 设置token
			$this->token = $response->authorizer_access_token;

			// 把token缓存起来
			$expiresAt = \Carbon::now()->addSeconds($response->expires_in);
			\Cache::put($this->cacheKey, $this->token, $expiresAt);
		}

		return $this->token;
	}
}

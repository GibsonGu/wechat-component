<?php namespace Gibson\Wechat;

use Carbon\Carbon;

/**
 * 全局通用 ComponentAccessToken
 */
class ComponentAccessToken
{
    const API_COMPONENT_TOKEN = 'https://api.weixin.qq.com/cgi-bin/component/api_component_token';
    protected $token;
    protected $cacheKey = 'gibson.wechat.component_access_token';

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
        if (!$this->token || $this->force) {
            $params = array(
                'component_appid' => \Config::get('wechat.appid'),
                'component_appsecret' => \Config::get('wechat.appsecret'),
                'component_verify_ticket' => ComponentVerifyTicket::getTicket(),
            );

            $http = new ComponentHttp();
            $response = $http->jsonPost(self::API_COMPONENT_TOKEN, $params);

            // 设置token
            $this->token = $response['component_access_token'];

            // 把token缓存起来
            $expiresAt = Carbon::now()->addSeconds($response['expires_in']);
            \Cache::put($this->cacheKey, $this->token, $expiresAt);
        }

        return $this->token;
    }
}

<?php namespace Gibson\Wechat;

/**
 * 授权给第三方平台
 */
class Component
{
    const API_CREATE_PREAUTHCODE = 'https://api.weixin.qq.com/cgi-bin/component/api_create_preauthcode';
    const API_QUERY_AUTH = 'https://api.weixin.qq.com/cgi-bin/component/api_query_auth';
    const API_GET_AUTHORIZER_INFO = 'https://api.weixin.qq.com/cgi-bin/component/api_get_authorizer_info';
    const API_GET_AUTHORIZER_OPTION = 'https://api.weixin.qq.com/cgi-bin/component/api_get_authorizer_option';
    const API_SET_AUTHORIZER_OPTION = 'https://api.weixin.qq.com/cgi-bin/component/api_set_authorizer_option';
    /**
     * 第三方平台appid
     *
     * @var string
     */
    protected $appid;
    protected $authorizer_appid;
    /**
     * Http对象
     *
     * @var ComponentHttp
     */
    protected $http;

    public function __construct()
    {
        $this->http = new ComponentHttp(new ComponentAccessToken());

        $this->appid = \Config::get('wechat.appid');
    }

    /**
     * 获取预授权码
     *
     * @return mixed
     */
    public function createPreAuthCode()
    {
        $params = array(
            'component_appid' => $this->appid,
        );

        return $this->http->jsonPost(self::API_CREATE_PREAUTHCODE, $params);
    }

    /**
     * 使用授权码换取公众号的授权信息
     *
     * @param $authorization_code
     * @return mixed
     */
    public function queryAuth($authorization_code)
    {
        $params = array(
            'component_appid' => $this->appid,
            'authorization_code' => $authorization_code,
        );

        return $this->http->jsonPost(self::API_QUERY_AUTH, $params);
    }

    /**
     * 获取授权方的账户信息
     *
     * @param $authorizer_appid
     * @return mixed
     */
    public function getAuthorizerInfo($authorizer_appid)
    {
        $params = array(
            'component_appid' => $this->appid,
            'authorizer_appid' => $authorizer_appid,
        );

        return $this->http->jsonPost(self::API_GET_AUTHORIZER_INFO, $params);
    }

    /**
     * 获取授权方的选项设置信息
     *
     * @param $authorizer_appid
     * @param $option_name
     * @return mixed
     */
    public function getAuthorizerOption($authorizer_appid, $option_name)
    {
        $params = array(
            'component_appid' => $this->appid,
            'authorizer_appid' => $authorizer_appid,
            'option_name' => $option_name,
        );

        return $this->http->jsonPost(self::API_GET_AUTHORIZER_OPTION, $params);
    }

    /**
     * 设置授权方的选项信息
     *
     * @param $authorizer_appid
     * @param $option_name
     * @param $option_value
     * @return mixed
     */
    public function setAuthorizerOption($authorizer_appid, $option_name, $option_value)
    {
        $params = array(
            'component_appid' => $this->appid,
            'authorizer_appid' => $authorizer_appid,
            'option_name' => $option_name,
            'option_value' => $option_value,
        );

        return $this->http->jsonPost(self::API_SET_AUTHORIZER_OPTION, $params);
    }
}

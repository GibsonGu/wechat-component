<?php namespace Gibson\Wechat;

/**
 * 颜色接口
 */
class Color extends \Overtrue\Wechat\Color
{

    /**
     * @param string|AccessToken $accessToken
     */
    public function __construct($accessToken)
    {
        $this->http = new Http($accessToken);
    }

    /**
     * 获取颜色列表
     *
     * @return array
     */
    public function lists()
    {
        $key = 'gibson.wechat.colors';

        // for php 5.3
        $http = $this->http;
        $apiList = self::API_LIST;

        return \Cache::get($key, function ($key) use ($http, $apiList) {
            $result = $http->get($apiList);

            \Cache::put($key, $result['colors'], 86400);// 1 day

            return $result['colors'];
        });
    }
}

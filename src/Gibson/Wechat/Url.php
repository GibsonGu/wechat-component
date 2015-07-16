<?php namespace Gibson\Wechat;

/**
 * 链接
 */
class Url extends \Overtrue\Wechat\Url
{
    /**
     * @param string|AccessToken $accessToken
     */
    public function __construct($accessToken)
    {
        $this->http = new Http($accessToken);
    }
}

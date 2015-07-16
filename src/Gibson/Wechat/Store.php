<?php namespace Gibson\Wechat;

/**
 * 门店
 */
class Store extends \Overtrue\Wechat\Store
{
    /**
     * @param string|AccessToken $accessToken
     */
    public function __construct($accessToken)
    {
        $this->http = new Http($accessToken);
    }
}

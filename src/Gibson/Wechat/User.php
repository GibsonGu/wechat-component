<?php namespace Gibson\Wechat;

/**
 * 用户
 */
class User
{
    /**
     * @param string|AccessToken $accessToken
     */
    public function __construct($accessToken)
    {
        $this->http = new Http($accessToken);
    }
}

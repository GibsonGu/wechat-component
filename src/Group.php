<?php

namespace Gibson\Wechat;

/**
 * 用户组
 */
class Group extends \Overtrue\Wechat\Group
{
    /**
     * @param string|AccessToken $accessToken
     */
    public function __construct($accessToken)
    {
        $this->http = new Http($accessToken);
    }
}

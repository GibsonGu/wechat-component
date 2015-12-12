<?php

namespace Gibson\Wechat;

/**
 * 自定义菜单
 */
class Menu extends \Overtrue\Wechat\Menu
{
    /**
     * @param string|AccessToken $accessToken
     */
    public function __construct($accessToken)
    {
        $this->http = new Http($accessToken);
    }
}

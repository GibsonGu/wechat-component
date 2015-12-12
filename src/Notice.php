<?php

namespace Gibson\Wechat;

class Notice extends \Overtrue\Wechat\Notice
{

    /**
     * @param string|AccessToken $accessToken
     */
    public function __construct($accessToken)
    {
        $this->http = new Http($accessToken);
    }
}

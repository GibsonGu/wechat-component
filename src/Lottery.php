<?php

namespace Gibson\Wechat;

class Lottery extends \Overtrue\Wechat\Lottery
{
    protected $http;

    public function __construct($accessToken)
    {
        $this->http = new Http($accessToken);
    }
}
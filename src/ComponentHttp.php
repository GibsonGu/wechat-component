<?php

namespace Gibson\Wechat;

class ComponentHttp extends HttpClient
{

    public function __construct($token = null)
    {
        $this->component_access_token = $token instanceof ComponentAccessToken ? $token->getToken() : $token;

        parent::__construct();
    }
}

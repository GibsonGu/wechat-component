<?php namespace Gibson\Wechat;

class Http extends HttpClient
{

    public function __construct($token = null)
    {
        $this->authorizer_access_token = $token instanceof AccessToken ? $token->getToken() : $token;

        parent::__construct();
    }
}

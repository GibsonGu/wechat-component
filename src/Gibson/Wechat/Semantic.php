<?php namespace Gibson\Wechat;

/**
 * 语义理解
 */
class Semantic extends \Overtrue\Wechat\Semantic
{
    /**
     * @param string $appId
     * @param string|AccessToken $accessToken
     */
    public function __construct($appId, $accessToken)
    {
        $this->appId = $appId;
        $this->http = new Http($accessToken);
    }
}

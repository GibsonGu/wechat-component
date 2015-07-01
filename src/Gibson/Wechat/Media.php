<?php namespace Gibson\Wechat;

/**
 * 媒体素材
 */
class Media extends \Overtrue\Wechat\Media
{
    /**
     * @param string|AccessToken $accessToken
     */
    public function __construct($accessToken)
    {
        $this->http = new Http($accessToken);
    }
}

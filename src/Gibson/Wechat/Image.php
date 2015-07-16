<?php namespace Gibson\Wechat;

/**
 * 图片上传服务
 */
class Image extends \Overtrue\Wechat\Image
{

    /**
     * @param string|AccessToken $accessToken
     */
    public function __construct($accessToken)
    {
        $this->http = new Http($accessToken);
    }
}

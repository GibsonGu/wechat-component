<?php namespace Gibson\Wechat;

use Overtrue\Wechat\Utils\Bag;

/**
 * 二维码
 */
class QRCode extends \Overtrue\Wechat\QRCode
{

    /**
     * @param string|AccessToken $accessToken
     */
    public function __construct($accessToken)
    {
        $this->http = new Http($accessToken);
    }

    /**
     * 创建二维码
     *
     * @param string $actionName
     * @param array $actionInfo
     * @param bool $temporary
     * @param int $expireSeconds
     *
     * @return Bag
     */
    protected function create($actionName, $actionInfo, $temporary = true, $expireSeconds = null)
    {
        $expireSeconds !== null || $expireSeconds = 7 * self::DAY;

        $params = array(
            'action_name' => $actionName,
            'action_info' => array('scene' => $actionInfo),
        );

        if ($temporary) {
            $params['expire_seconds'] = min($expireSeconds, 7 * self::DAY);
        }

        return new Bag($this->http->jsonPost(self::API_CREATE, $params));
    }
}

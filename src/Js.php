<?php

namespace Gibson\Wechat;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class Js extends \Overtrue\Wechat\Js
{
    const API_TICKET = 'https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi';

    /**
     * 应用ID
     *
     * @var string
     */
    protected $appId;

    /**
     * 缓存前缀
     *
     * @var string
     */
    protected $cacheKey = 'gibson.wechat.jsapi_ticket.%s';

    /**
     * Http对象
     *
     * @var Http
     */
    protected $http;

    /**
     * constructor
     *
     * @param string $accessToken
     * @param string $authorizerAppId
     */
    public function __construct($accessToken, $authorizerAppId)
    {
        $this->http = new Http($accessToken);

        $this->appId = $authorizerAppId;
    }

    /**
     * 获取jsticket
     *
     * @return string
     */
    public function getTicket()
    {
        $cacheKey = sprintf($this->cacheKey, $this->appId);

        return Cache::get($cacheKey, function () use ($cacheKey) {
            $response = $this->http->get(self::API_TICKET);

            // 设置token
            $ticket = $response['ticket'];

            // 把token缓存起来
            $expiresAt = Carbon::now()->addSeconds($response['expires_in']);
            Cache::put($cacheKey, $ticket, $expiresAt);

            return $ticket;
        });
    }
}
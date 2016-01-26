<?php

namespace Gibson\Wechat;

use Illuminate\Support\Facades\Cache;

/**
 * 卡券
 */
class Card extends \Overtrue\Wechat\Card
{

    /**
     * @param string|AccessToken $accessToken
     */
    public function __construct($accessToken)
    {
        $this->http = new Http($accessToken);
    }

    /**
     * 获取jsticket
     *
     * @return string
     */
    public function getTicket()
    {
        if ($this->ticket) {
            return $this->ticket;
        }

        $key = 'gibson.wechat.card.api_ticket';

        // for php 5.3
        $http = $this->http;
        $apiTicket = self::API_TICKET;

        return $this->ticket = Cache::get($key, function () use ($key, $http, $apiTicket) {
            $result = $http->get($apiTicket);

            Cache::put($key, $result['ticket'], $result['expires_in']);

            return $result['ticket'];
        });
    }
}

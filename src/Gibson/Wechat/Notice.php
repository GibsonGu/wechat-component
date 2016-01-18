<?php namespace Gibson\Wechat;

class Notice extends \Overtrue\Wechat\Notice
{
    const API_GET_INDUSTRY = 'https://api.weixin.qq.com/cgi-bin/template/get_industry';

    /**
     * @param string|AccessToken $accessToken
     */
    public function __construct($accessToken)
    {
        $this->http = new Http($accessToken);
    }

    /**
     * 获取账号所属行业
     *
     * @param int $industryOne
     * @param int $industryTwo
     *
     * @return bool
     */
    public function getIndustry()
    {
        return $this->http->get(self::API_GET_INDUSTRY);
    }
}

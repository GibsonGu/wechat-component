<?php

namespace Gibson\Wechat;

class MassMessage
{

    const API_SEND = 'https://api.weixin.qq.com/cgi-bin/message/mass/sendall';
    const API_PREVIEW = 'https://api.weixin.qq.com/cgi-bin/message/mass/preview';
    const API_GET = 'https://api.weixin.qq.com/cgi-bin/message/mass/get';
    const API_DELETE = 'https://api.weixin.qq.com/cgi-bin/message/mass/delete';

    /**
     * Http对象
     *
     * @var Http
     */
    protected $http;

    public function __construct($accessToken)
    {
        $this->http = new Http($accessToken);
    }

    /**
     * 根据分组进行群发
     *
     * @param array $filter = ['is_to_all'=>true|false, 'group_id'=>int]
     * @param array $message
     * @return bool
     */
    public function sendByGroup($filter = [], $message = [])
    {
        $msg = array_merge(['filter' => $filter], $message);
        $msg['msgtype'] = array_keys($message)[0];

        return $this->http->jsonPost(self::API_SEND, $msg);

    }

    /**
     * 根据openid进行群发
     *
     * @param array $touser
     * @param array $message
     * @return bool
     */
    public function sendByOpenid($touser = [], $message = [])
    {
        $msg = array_merge(['touser' => $touser], $message);
        $msg['msgtype'] = array_keys($message)[0];

        return $this->http->jsonPost(self::API_SEND, $msg);
    }

    /**
     * 通过openid预览
     *
     * @param $openid
     * @param array $message
     * @return mixed
     */
    public function previewByOpenid($openid, $message = [])
    {
        $msg = array_merge(['touser' => $openid], $message);
        $msg['msgtype'] = array_keys($message)[0];

        return $this->http->jsonPost(self::API_PREVIEW, $msg);
    }

    /**
     * 通过微信号预览
     *
     * @param $wxname
     * @param array $message
     * @return mixed
     */
    public function previewByName($wxname, $message = [])
    {
        $msg = array_merge(['towxname' => $wxname], $message);
        $msg['msgtype'] = array_keys($message)[0];

        return $this->http->jsonPost(self::API_PREVIEW, $msg);
    }

    /**
     * 查询群发消息发送状态
     *
     * @param $msg_id
     * @return mixed
     */
    public function get($msg_id)
    {
        return $this->http->jsonPost(self::API_GET, ['msg_id' => $msg_id]);
    }

    /**
     * 删除群发消息
     *
     * @param $msg_id
     * @return mixed
     */
    public function delete($msg_id)
    {
        return $this->http->jsonPost(self::API_DELETE, ['msg_id' => $msg_id]);
    }
}
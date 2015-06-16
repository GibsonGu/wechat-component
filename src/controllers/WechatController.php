<?php namespace Gibson\Wechat\Controllers;

use Gibson\Wechat\ComponentVerifyTicket;
use Illuminate\Routing\Controller;
use Overtrue\Wechat\Crypt;
use Overtrue\Wechat\Exception;

class WechatController extends Controller
{
	protected $appid;

	protected $token;

	protected $encryptKey;

	public function __construct()
	{
		$this->appid = \Config::get('wechat::appid');
		$this->token = \Config::get('wechat::token');
		$this->encryptKey = \Config::get('wechat::encryptKey');
	}

	public function handleEvent()
	{
		$request = $this->pushMsg();

		switch ($request->InfoType)
		{
			case 'component_verify_ticket':
				ComponentVerifyTicket::setTicket($request->ComponentVerifyTicket);
				break;

			case 'unauthorized':
				$this->msgResponse($request);
				break;
		}
	}

	/**
	 * 初始化POST请求数据
	 */
	protected function pushMsg()
	{
		$postData = file_get_contents('php://input');

		\Log::debug('WechatPushMsg', ['handleEvent'=>$postData]);

		$decryptMsg = $this->getCrypt()->decryptMsg(
				$_REQUEST['msg_signature'],
				$_REQUEST['nonce'],
				$_REQUEST['timestamp'],
				$postData
		);

		return simplexml_load_string($decryptMsg, 'SimpleXMLElement', LIBXML_NOCDATA);
	}

	/**
	 * 获取Crypt服务
	 */
	protected function getCrypt()
	{
		static $crypt;

		if (!$crypt) {
			if (empty($this->encodingAESKey) || empty($this->token)) {
				throw new Exception("加密模式下 'encodingAESKey' 与 'token' 都不能为空！");
			}

			$crypt = new Crypt($this->appid, $this->token, $this->encodingAESKey);
		}

		return $crypt;
	}
}
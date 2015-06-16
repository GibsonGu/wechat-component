<?php namespace Gibson\Wechat\Controllers;

use Gibson\Wechat\Component;
use Gibson\Wechat\ComponentVerifyTicket;
use Illuminate\Routing\Controller;
use Overtrue\Wechat\Crypt;
use Overtrue\Wechat\Exception;

class WechatController extends Controller
{
	protected $appid;

	protected $token;

	protected $encryptKey;

	protected $cacheKey = 'gibson.wechat.pre_auth_code';

	protected $component_login_page = 'https://mp.weixin.qq.com/cgi-bin/componentloginpage?component_appid=%s&pre_auth_code=%s&redirect_uri=%s';

	public function __construct()
	{
		$this->appid = \Config::get('wechat::appid');
		$this->token = \Config::get('wechat::token');
		$this->encodingAESKey = \Config::get('wechat::encodingAESKey');
	}

	public function authorize()
	{
		$appid = $this->appid;
		$pre_auth_code = $this->createPreAuthCode();
		$redirect_uri = urlencode(\Request::getUri());

		// 拼接出微信公众号登录授权页面url
		$url = sprintf($this->component_login_page, $appid, $pre_auth_code, $redirect_uri);

		return \Redirect::to($url);
	}

	public function handleEvent()
	{
		\Log::debug('WechatPushMsg');

		$request = $this->pushMsg();

		switch ($request['InfoType'])
		{
			case 'component_verify_ticket':
				ComponentVerifyTicket::setTicket($request['ComponentVerifyTicket']);
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
				\Input::get('msg_signature'),
				\Input::get('nonce'),
				\Input::get('timestamp'),
				$postData
		);

		\Log::debug('Input', \Input::all());
		\Log::debug('decryptMsg', [$decryptMsg]);

		return $decryptMsg;
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

	/**
	 * 获取预授权码
	 *
	 * @return mixed
	 */
	protected function createPreAuthCode()
	{
		$pre_auth_code = \Cache::get($this->cacheKey);

		if(!$pre_auth_code)
		{
			$component = new Component();
			$response = $component->createPreAuthCode();
			$pre_auth_code = $response->pre_auth_code;

			// 把pre_auth_code缓存起来
			$expiresAt = \Carbon::now()->addSeconds($response->expires_in);
			\Cache::put($this->cacheKey, $pre_auth_code, $expiresAt);
		}

		return $pre_auth_code;
	}
}
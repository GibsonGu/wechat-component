<?php

namespace Gibson\Wechat\Middleware;

use Closure;
use Illuminate\Support\Facades\Config;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

/*
|--------------------------------------------------------------------------
| Wechat Signature Middleware
|--------------------------------------------------------------------------
|
| 过滤掉来源不是微信的请求.
|
| 先去获取到微信请求里面包含的几项内容,我们需要用到这几个东西.
| 按照微信的方法加工一个自己的signature,然后再用这个signature去跟在请求里面包含的signature去对比.
| 如果不匹配的话,就返回 false.
|
*/

class WechatSignature
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // 获取到微信请求里包含的几项内容
        $signature = $request->input('signature');
        $timestamp = $request->input('timestamp');
        $nonce = $request->input('nonce');

        // 公众号消息校验Token
        $token = Config::get('wechat.encodingToken');

        // 加工出自己的 signature
        $our_signature = array($token, $timestamp, $nonce);
        sort($our_signature, SORT_STRING);
        $our_signature = implode($our_signature);
        $our_signature = sha1($our_signature);

        // 用自己的 signature 去跟请求里的 signature 对比
        if ($our_signature !== $signature) {
            throw new AccessDeniedHttpException('Access Denied');
        }

        return $next($request);
    }
}
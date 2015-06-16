<?php

Route::group(['prefix'=>'weixin', 'namespace'=>'Gibson\Wechat\Controllers'], function()
{
	Route::post('handleevent', ['uses'=>'WechatController@handleEvent']);
	Route::get('authorize', ['uses'=>'WechatController@authorize']);
});
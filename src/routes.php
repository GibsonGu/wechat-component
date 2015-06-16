<?php

Route::group(['prefix'=>'wechat', 'namespace'=>'Gibson\Wechat\Controllers'], function()
{
	Route::any('handleevent', ['uses'=>'WechatController@handleEvent']);
	Route::get('authorize', ['uses'=>'WechatController@authorize']);
});
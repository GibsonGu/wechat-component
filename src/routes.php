<?php

Route::group(['prefix'=>'wechat', 'namespace'=>'Gibson\Wechat\Controllers'], function()
{
	Route::get('handleevent', ['uses'=>'WechatController']);
});
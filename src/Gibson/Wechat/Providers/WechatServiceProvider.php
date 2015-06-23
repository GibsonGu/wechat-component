<?php namespace Gibson\Wechat\Providers;

use Illuminate\Support\ServiceProvider;

class WechatServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$path = realpath(__DIR__.'/../../../');

		$this->package('gibson/wechat', 'wechat', $path);

		include $path.'/filters.php';
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('wechat');
	}

}

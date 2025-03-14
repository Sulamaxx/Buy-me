<?php

namespace extras\plugins\webxpay;

use Illuminate\Support\ServiceProvider;

class WebxpayServiceProvider extends ServiceProvider
{
	/**
	 * Perform post-registration booting of services.
	 *
	 * @return void
	 */
	public function boot(): void
	{
		// Load plugin views
		$this->loadViewsFrom(realpath(__DIR__ . '/resources/views'), 'payment');
		
		// Load plugin languages files
		$this->loadTranslationsFrom(realpath(__DIR__ . '/lang'), 'webxpay');
		
		// Merge plugin config
		$this->mergeConfigFrom(realpath(__DIR__ . '/config.php'), 'payment');

		//Won  Route
		$this->loadRoutesFrom(__DIR__ . '/routes/api.php');
	}
	
	/**
	 * Register any package services.
	 *
	 * @return void
	 */
	public function register(): void
	{
		$this->app->bind('webxpay', fn () => new WebxPay());
	}
}

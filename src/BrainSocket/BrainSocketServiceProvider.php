<?php
namespace BrainSocket;

use Illuminate\Support\ServiceProvider;

class BrainSocketServiceProvider extends ServiceProvider {

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

	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{

		$this->app->singleton('brain_socket', function($app){
			return new BrainSocketAppResponse();
		});

		$this->app->singleton('command.brainsocket.start', function($app)
		{
			return new BrainSocket();
		});
		$this->commands('command.brainsocket.start');
	}


	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('brain_socket','command.brainsocket.start');
	}

}

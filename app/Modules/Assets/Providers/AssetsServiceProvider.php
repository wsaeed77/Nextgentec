<?php
namespace App\Modules\Assets\Providers;

use App;
use Config;
use Lang;
use View;
use Illuminate\Support\ServiceProvider;

class AssetsServiceProvider extends ServiceProvider
{
	/**
	 * Register the Assets module service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		// This service provider is a convenient place to register your modules
		// services in the IoC container. If you wish, you may make additional
		// methods or service providers to keep the code more focused and granular.
		App::register('App\Modules\Assets\Providers\RouteServiceProvider');

		$this->registerNamespaces();
	}

	/**
	 * Register the Assets module resource namespaces.
	 *
	 * @return void
	 */
	protected function registerNamespaces()
	{
		Lang::addNamespace('assets', realpath(__DIR__.'/../Resources/Lang'));
		
		View::addNamespace('assets', base_path('resources/views/vendor/assets'));
		View::addNamespace('assets', realpath(__DIR__.'/../Resources/Views'));
	}
}

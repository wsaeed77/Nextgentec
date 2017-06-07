<?php
namespace App\Modules\Vendor\Providers;

use App;
use Config;
use Lang;
use View;
use Illuminate\Support\ServiceProvider;

class VendorServiceProvider extends ServiceProvider
{
	/**
	 * Register the Vendor module service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		// This service provider is a convenient place to register your modules
		// services in the IoC container. If you wish, you may make additional
		// methods or service providers to keep the code more focused and granular.
		App::register('App\Modules\Vendor\Providers\RouteServiceProvider');

		$this->registerNamespaces();
	}

	/**
	 * Register the Vendor module resource namespaces.
	 *
	 * @return void
	 */
	protected function registerNamespaces()
	{
		Lang::addNamespace('vendor', realpath(__DIR__.'/../Resources/Lang'));
		
		View::addNamespace('vendor', base_path('resources/views/vendor/vendor'));
		View::addNamespace('vendor', realpath(__DIR__.'/../Resources/Views'));
	}
}

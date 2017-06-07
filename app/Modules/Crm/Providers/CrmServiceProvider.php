<?php
namespace App\Modules\Crm\Providers;

use App;
use Config;
use Lang;
use View;
use Illuminate\Support\ServiceProvider;

class CrmServiceProvider extends ServiceProvider
{
	/**
	 * Register the Crm module service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		// This service provider is a convenient place to register your modules
		// services in the IoC container. If you wish, you may make additional
		// methods or service providers to keep the code more focused and granular.
		App::register('App\Modules\Crm\Providers\RouteServiceProvider');

		$this->registerNamespaces();
	}

	/**
	 * Register the Crm module resource namespaces.
	 *
	 * @return void
	 */
	protected function registerNamespaces()
	{
		Lang::addNamespace('crm', realpath(__DIR__.'/../Resources/Lang'));
		
		View::addNamespace('crm', base_path('resources/views/vendor/crm'));
		View::addNamespace('crm', realpath(__DIR__.'/../Resources/Views'));
	}
}

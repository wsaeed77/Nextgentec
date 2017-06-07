<?php
namespace App\Modules\Employee\Providers;

use App;
use Config;
use Lang;
use View;
use Illuminate\Support\ServiceProvider;

class EmployeeServiceProvider extends ServiceProvider
{
	/**
	 * Register the Employee module service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		// This service provider is a convenient place to register your modules
		// services in the IoC container. If you wish, you may make additional
		// methods or service providers to keep the code more focused and granular.
		App::register('App\Modules\Employee\Providers\RouteServiceProvider');

		$this->registerNamespaces();
	}

	/**
	 * Register the Employee module resource namespaces.
	 *
	 * @return void
	 */
	protected function registerNamespaces()
	{
		Lang::addNamespace('employee', realpath(__DIR__.'/../Resources/Lang'));
		
		View::addNamespace('employee', base_path('resources/views/vendor/employee'));
		View::addNamespace('employee', realpath(__DIR__.'/../Resources/Views'));
	}
}

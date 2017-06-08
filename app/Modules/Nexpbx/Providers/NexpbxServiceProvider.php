<?php
namespace App\Modules\Nexpbx\Providers;

use App;
use Config;
use Lang;
use View;
use Illuminate\Support\ServiceProvider;

class NexpbxServiceProvider extends ServiceProvider
{
    /**
     * Register the Nexpbx module service provider.
     *
     * @return void
     */
    public function register()
    {
        // This service provider is a convenient place to register your modules
        // services in the IoC container. If you wish, you may make additional
        // methods or service providers to keep the code more focused and granular.
        App::register('App\Modules\Nexpbx\Providers\RouteServiceProvider');

        $this->registerNamespaces();
    }

    /**
     * Register the Nexpbx module resource namespaces.
     *
     * @return void
     */
    protected function registerNamespaces()
    {
        Lang::addNamespace('nexpbx', realpath(__DIR__.'/../Resources/Lang'));
        
        View::addNamespace('nexpbx', base_path('resources/views/vendor/nexpbx'));
        View::addNamespace('nexpbx', realpath(__DIR__.'/../Resources/Views'));
    }
}

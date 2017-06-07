<?php
namespace App\Modules\Backupmanager\Providers;

use App;
use Config;
use Lang;
use View;
use Illuminate\Support\ServiceProvider;

class BackupmanagerServiceProvider extends ServiceProvider
{
    /**
     * Register the Backupmanager module service provider.
     *
     * @return void
     */
    public function register()
    {
        // This service provider is a convenient place to register your modules
        // services in the IoC container. If you wish, you may make additional
        // methods or service providers to keep the code more focused and granular.
        App::register('App\Modules\Backupmanager\Providers\RouteServiceProvider');

        $this->registerNamespaces();
    }

    /**
     * Register the Backupmanager module resource namespaces.
     *
     * @return void
     */
    protected function registerNamespaces()
    {
        Lang::addNamespace('backupmanager', realpath(__DIR__.'/../Resources/Lang'));
        
        View::addNamespace('backupmanager', base_path('resources/views/vendor/backupmanager'));
        View::addNamespace('backupmanager', realpath(__DIR__.'/../Resources/Views'));
    }
}

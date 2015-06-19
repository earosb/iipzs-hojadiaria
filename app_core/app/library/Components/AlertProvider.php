<?php namespace Components;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class AlertProvider extends ServiceProvider
{
    public function register()
    {
        $this->registerAlert();
        $this->setAliases();
    }

    public function registerAlert()
    {
        $this->app->bind('alert', function ($app) {
            return new Alert($app['session.store'], $app['view']);
        });
    }

    public function setAliases()
    {
        $this->app->booting(function () {
            $loader = AliasLoader::getInstance();
            // Facades
            $loader->alias('Alert', 'Components\AlertFacade');
        });
    }

}
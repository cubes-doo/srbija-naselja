<?php
namespace CubesDoo\SrbijaNaselja\Laravel;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use CubesDoo\SrbijaNaselja\SrbijaNaseljaService;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    //protected $defer = true;


    public function register()
    {
        $this->app->singleton(SrbijaNaseljaService::class, function ($app) {
            
            $service = SrbijaNaseljaService::getInstance();
            if ($app->getLocale() == 'sr') {
                $service->setDefaultLang('sr_RS');
            }

            return $service;
        });

        $this->app->alias(SrbijaNaseljaService::class, 'SrbijaNaselja');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [SrbijaNaseljaService::class];
    }
}
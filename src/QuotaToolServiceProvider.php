<?php

namespace Nurmanhabib\QuotaTool;

use Illuminate\Support\ServiceProvider;

class QuotaToolServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/quotatool.php' => config_path('quotatool.php'),
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/quotatool.php', 'quotatool'
        );

        $this->app->bind('quotatool', function($app) {
            $filesystem = $app->config->get('quotatool.filesystem');
            $command    = $app->config->get('quotatool.command');

            return new QuotaTool($filesystem, $command);
        });

        $this->app->booting( function() {
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();
            $loader->alias('QuotaTool', 'Nurmanhabib\QuotaTool\Facades\QuotaTool');
        });
    }
}

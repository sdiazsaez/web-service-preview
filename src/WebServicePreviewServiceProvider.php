<?php

namespace Larangular\WebServicePreview;

use Illuminate\Support\ServiceProvider;
use Larangular\WebServiceManager\WebServiceManagerServiceProvider;

class WebServicePreviewServiceProvider extends ServiceProvider {
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot() {
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/../views/', 'larangular.web-service-preview');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register() {
        $this->app->register(WebServiceManagerServiceProvider::class);
    }
}


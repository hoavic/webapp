<?php

namespace Hoadev\CoreBlog\Providers;

use Illuminate\Support\ServiceProvider;

class CoreBlogProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        /* $this->loadRoutesFrom(__DIR__.'/../routes/web.php'); */
        $this->loadViewsFrom(__DIR__.'/../views', 'coreblog');
       /*  dd('active'); */

        $this->publishes([
            __DIR__.'/../resources/js/Pages/' => resource_path('/js/Pages/CoreBlog/'),
        ], 'coreblog-js');

    }
}

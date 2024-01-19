<?php

namespace Hoadev\CoreForm\Providers;

use Hoadev\CoreForm\Models\Form;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class CoreFormProvider extends ServiceProvider
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
        $this->loadViewsFrom(__DIR__.'/../views', 'coreform');
       /*  dd('active'); */

/*         $this->publishes([
            __DIR__.'/../config/coreshop.php' => config_path('coreshop.php'),
        ], 'coreshop-config'); */

/*         $this->publishes([
            __DIR__.'/../resources/js/Pages/' => resource_path('/js/Pages/CoreShop/'),
        ], 'coreshop-js'); */

        $this->publishes([
            __DIR__.'/../database/seeders' => database_path('seeders'),
        ], 'coreshop-seeders');

    }
}

<?php

namespace Hoadev\CoreShop\Traits;

use Hoadev\CoreShop\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

trait CoreShopRoute {

    public static function Admin() {

        Route::name('admin.')->group(function() {

            Route::resource('products', ProductController::class);

        });
    }

    public static function Guest() {

    }

}

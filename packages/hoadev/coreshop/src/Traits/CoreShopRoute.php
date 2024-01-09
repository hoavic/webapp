<?php

namespace Hoadev\CoreShop\Traits;

use Hoadev\CoreShop\Http\Controllers\PermalinkShopController;
use Hoadev\CoreShop\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

trait CoreShopRoute {

    public static function Admin() {

        Route::name('admin.')->group(function() {

            Route::resource('products', ProductController::class);

        });
    }

    public static function Guest() {

        Route::get('product/{name}', [PermalinkShopController::class, 'product'])->name('permalink.product');

        Route::get('product_category/{slug}', [PermalinkShopController::class, 'productCategory'])->name('permalink.product_category');
        Route::get('product_category/{parent}/{slug}', [PermalinkShopController::class, 'productCategoryHasParent'])->name('permalink.product_category.hasParent');
        Route::get('product_category/{grand}/{parent}/{slug}', [PermalinkShopController::class, 'productCategoryHasGrand'])->name('permalink.product_category.hasGrand');

    }

}

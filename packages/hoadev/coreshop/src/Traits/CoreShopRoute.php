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

        $product_slug = config('coreblog.post_types.product.rewrite') ?? config('coreblog.post_types.product.type');
        Route::get($product_slug.'/{name}', [PermalinkShopController::class, 'product'])->name('permalink.product');

        $product_category_slug = config('coreblog.taxonomies.product_category.rewrite') ?? config('coreblog.taxonomies.product_category.taxonomy');
        Route::get($product_category_slug.'/{slug}', [PermalinkShopController::class, 'productCategory'])->name('permalink.product_category');
        Route::get($product_category_slug.'/{parent?}/{slug}', [PermalinkShopController::class, 'productCategoryHasParent'])->name('permalink.product_category.hasParent')->where($product_category_slug, '.*');

    }

}

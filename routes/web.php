<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Hoadev\CoreBlog\Traits\CoreBlogRoute;
use Hoadev\CoreForm\Traits\CoreFormRoute;
use Hoadev\CoreShop\Traits\CoreShopRoute;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function() { return redirect()->route('dashboard'); });

Route::group([
    'prefix' => 'admin',
    'middleware' => [
        'auth:sanctum',
        config('jetstream.auth_session'),
        'verified',
    ]
], function () {

    /* Route::get('/', function() { return redirect()->route('dashboard'); }); */

/*     Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard'); */
    CoreFormRoute::Admin();
    CoreShopRoute::Admin();
    CoreBlogRoute::Admin();
});
CoreFormRoute::Guest();
CoreShopRoute::Guest();
CoreBlogRoute::Guest();

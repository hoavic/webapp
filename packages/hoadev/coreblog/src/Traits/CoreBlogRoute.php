<?php

namespace Hoadev\CoreBlog\Traits;

use Hoadev\CoreBlog\Http\Controllers\CoreBlogController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

trait CoreBlogRoute {

    public static function Init() {


        Route::get('/', function() {
            return 'active'; //dmeo
        });

        Route::get('/', function() { return redirect()->route('dashboard'); });

        Route::get('/dashboard', function () {
            return Inertia::render('CoreBlog/Admin/Dashboard');
        })->name('dashboard');

        Route::get('coreblog', CoreBlogController::class); //demo


    }

}

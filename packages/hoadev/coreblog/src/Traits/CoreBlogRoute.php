<?php

namespace Hoadev\CoreBlog\Traits;

use Hoadev\CoreBlog\Http\Controllers\CoreBlogController;
use Hoadev\CoreBlog\Http\Controllers\PostController;
use Hoadev\CoreBlog\Http\Controllers\TermController;
use Hoadev\CoreBlog\Models\Comment;
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

        Route::resource('posts', PostController::class);
        Route::resource('comments', CommentController::class);
        Route::resource('terms', TermController::class);
    }

}

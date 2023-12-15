<?php

namespace Hoadev\CoreBlog\Traits;

use Hoadev\CoreBlog\Http\Controllers\CommentController;
use Hoadev\CoreBlog\Http\Controllers\CoreBlogController;
use Hoadev\CoreBlog\Http\Controllers\PermalinkController;
use Hoadev\CoreBlog\Http\Controllers\PostController;
use Hoadev\CoreBlog\Http\Controllers\TermController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

trait CoreBlogRoute {

    public static function Admin() {

        Route::get('/dashboard', function () {
            return Inertia::render('CoreBlog/Admin/Dashboard');
        })->name('dashboard');

        Route::name('admin.')->group(function() {
            Route::get('/', function() {
                return 'active'; //dmeo
            });

            Route::get('/', function() { return redirect()->route('dashboard'); });
            Route::get('coreblog', CoreBlogController::class); //demo

            Route::resource('terms', TermController::class)->except(['show']);
            Route::get('/terms/by-taxonomy', [TermController::class, 'getTermByTaxonomy'])->name('terms.by-taxonomy');
            Route::post('/terms/store-and-response', [TermController::class, 'StoreAndResponse'])->name('terms.store-and-response');

            Route::resource('posts', PostController::class);
            Route::resource('comments', CommentController::class);

        });
    }

    public static function Guest() {

        Route::get('/', function() {

        })->name('home');

        Route::get('{name}', [PermalinkController::class, 'single'])->name('permalink.single');

        Route::get('{type}/{name}', [PermalinkController::class, 'post'])->name('permalink.post')->whereIn('type', ['post', 'page', 'news', 'blog']);
        Route::get('{type}/{slug}', [PermalinkController::class, 'term'])->name('permalink.term')->whereIn('type', ['category', 'tag']);

        Route::get('{parent}/{slug}', [PermalinkController::class, 'categoryHasParent'])->name('permalink.category.hasParent');

        Route::get('{type}/{parent}/{slug}', [PermalinkController::class, 'termHasParent'])->name('permalink.term.hasParent')->whereIn('type', ['category', 'tag']);
        Route::get('{grand}/{parent}/{slug}', [PermalinkController::class, 'categoryHasGrand'])->name('permalink.category.hasGrand');

        Route::get('{type}/{grand}/{parent}/{slug}', [PermalinkController::class, 'termHasGrand'])->name('permalink.term.hasGrand')->whereIn('type', ['category', 'tag']);
        /* Route::get('{taxonomy}/{slug}', [TermController::class, 'show'])->name('terms.show'); */
    }

}

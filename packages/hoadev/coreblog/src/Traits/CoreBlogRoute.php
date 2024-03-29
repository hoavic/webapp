<?php

namespace Hoadev\CoreBlog\Traits;

use Hoadev\CoreBlog\Http\Controllers\MediaController;
use Hoadev\CoreBlog\Http\Controllers\CommentController;
use Hoadev\CoreBlog\Http\Controllers\CoreBlogController;
use Hoadev\CoreBlog\Http\Controllers\HomeController;
use Hoadev\CoreBlog\Http\Controllers\PermalinkController;
use Hoadev\CoreBlog\Http\Controllers\PostController;
use Hoadev\CoreBlog\Http\Controllers\SitemapController;
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

            Route::get('/terms/by-taxonomy', [TermController::class, 'getTermByTaxonomy'])->name('terms.by-taxonomy');
            Route::post('/terms/store-and-response', [TermController::class, 'StoreAndResponse'])->name('terms.store-and-response');
            Route::resource('terms', TermController::class)->except(['show']);

            Route::resource('medias', MediaController::class);
            Route::get('/medias-popup', [MediaController::class, 'popup'])->name('medias.popup');
            Route::get('/medias-popup-data', [MediaController::class, 'popupData'])->name('medias.popup-data');

            Route::resource('posts', PostController::class);
            Route::resource('comments', CommentController::class);

        });
    }

    public static function Guest() {

        Route::get('/', [HomeController::class, 'default'])->name('home');

        Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap.index');

        //fix tam, sau nay remove
        Route::get('{old_key_link}/{any?}', function($old_key_link, $any) {

            switch($old_key_link) {
                case 'product':
                    return redirect('/san-pham/'.$any);
                    break;

                case 'product-category':
                    return redirect('/danh-muc/'.$any);
                    break;

                default:
                    return redirect('/');
                    break;

            }
        })->whereIn('old_key_link', ['product', 'product_category']);

        $post_types = config('coreblog.post_types');
        $has_archive_page_types = [];
        foreach($post_types as $post_type) {
            if(isset($post_type['has_archive']) && $post_type['has_archive']) {$has_archive_page_types[] = $post_type['archive_page'] ?? $post_type['type'];}
        }

        Route::get('{post_type}', [PermalinkController::class, 'archive'])->name('permalink.archive')->whereIn('post_type', $has_archive_page_types);

        Route::get('{name}', [PermalinkController::class, 'single'])->name('permalink.single');

        $public_types = [];
        foreach($post_types as $post_type) {
            if(isset($post_type['public']) && $post_type['public']) {
                $public_types[] = $post_type['rewrite'] ?? $post_type['type'];
            }
        }
        Route::get('{type}/{name}', [PermalinkController::class, 'post'])->name('permalink.post')->whereIn('type', $public_types);

        $accept_taxonomies = [];
        foreach(config('coreblog.taxonomies') as $taxonomy) {
            if(isset($taxonomy['public']) && $taxonomy['public'] && $taxonomy['taxonomy'] !== 'category') {$accept_taxonomies[] = $taxonomy['rewrite'] ?? $taxonomy['taxonomy'];}
        }

        Route::get('{type}/{parent?}/{slug}', [PermalinkController::class, 'termHasParent'])->name('permalink.term.hasParent')->whereIn('type', $accept_taxonomies)->where('parent', '.*');
        Route::get('{parent}/{slug}', [PermalinkController::class, 'categoryHasParent'])->name('permalink.category.hasParent')->where('parent', '.*');

    }

}

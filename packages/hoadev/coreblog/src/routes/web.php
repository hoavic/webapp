<?php

use Hoadev\CoreBlog\Http\Controllers\CoreBlogController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'admin'
], function() {

    Route::get('/', function() {
        return 'active';
    });
    Route::get('coreblog', CoreBlogController::class);

});

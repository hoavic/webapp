<?php

namespace Hoadev\CoreForm\Traits;

use Hoadev\CoreForm\Http\Controllers\FormController;
use Illuminate\Support\Facades\Route;

trait CoreFormRoute {

    public static function Admin() {

        Route::name('admin.')->group(function() {
            Route::post('forms/{id}/restore', [FormController::class, 'restore'])->name('forms.restore');
            Route::resource('forms', FormController::class)->except(['store', 'show']);

        });
    }

    public static function Guest() {

        Route::post('/store-form-s', [FormController::class, 'store'])->name('form.store');
        /* Route::get('/receipt', [FormController::class, 'receipt'])->name('form.receipt'); */
    }

}

<?php

use App\Http\Controllers\DistributionController;
use App\Http\Controllers\DistributionProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('distributions.index');
});


Route::controller(DistributionController::class)->group(function () {
    Route::get('/distributions', 'index')->name('distributions.index');
    Route::get('/distributions/create', 'create')->name('distributions.create');
    Route::post('/distributions', 'store')->name('distributions.store');
    Route::get('/distributions/{id}', 'show')->name('distributions.show');
    Route::delete('/distributions/{id}', 'destroy')->name('distributions.destroy');
    // endpoint used by DataTable
    Route::get('/distributions-data', 'data')->name('distributions.data');
});


Route::controller(DistributionProductController::class)->group(function () {
    Route::get('/distribution-products', 'index')->name('distribution-products.index'); // list temporary
    Route::post('/distribution-products', 'store')->name('distribution-products.store');
    Route::delete('/distribution-products/{id}', 'destroy')->name('distribution-products.destroy');
});

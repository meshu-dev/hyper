<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('sites/{siteId}')->group(function () {
    Route::prefix('blogs/')->group(function () {
        Route::get('/', [App\Http\Controllers\BlogController::class, 'getList']);
        Route::get('/tag/{tag}', [App\Http\Controllers\BlogController::class, 'getByTag']);
        Route::get('/search/{search}', [App\Http\Controllers\BlogController::class, 'search']);
        Route::get('/slugs', [App\Http\Controllers\BlogController::class, 'getSlugs']);
        Route::get('/total-pages', [App\Http\Controllers\BlogController::class, 'getTotalPages']);
        Route::get('/{slug}', [App\Http\Controllers\BlogController::class, 'getBySlug']);
    });

    Route::prefix('tags')->group(function () {
        Route::get('/', [App\Http\Controllers\TagController::class, 'getAll']);
    });
});

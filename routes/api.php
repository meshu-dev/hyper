<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('blogs')->group(function () {
    Route::prefix('published')->group(function () {
        Route::get('/', [App\Http\Controllers\BlogController::class, 'getPublished']);
        Route::get('/tag/{tag}', [App\Http\Controllers\BlogController::class, 'getPublishedByTag']);
        Route::get('/search/{search}', [App\Http\Controllers\BlogController::class, 'getPublishedBySearch']);
        Route::get('/slugs', [App\Http\Controllers\BlogController::class, 'getSlugs']);
        Route::get('/{slug}', [App\Http\Controllers\BlogController::class, 'getPublishedBySlug']);
    });
});

Route::prefix('tags')->group(function () {
    Route::get('/', [App\Http\Controllers\TagController::class, 'getAll']);
});

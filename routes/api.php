<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\TagController;
use App\Http\Middleware\GetSiteId;
use Illuminate\Support\Facades\Route;

Route::post('auth/login', [AuthController::class, 'login'])->name('login');

Route::prefix('sites/{site}')->middleware(['auth:sanctum', GetSiteId::class])->group(function () {
    Route::prefix('blogs/')->group(function () {
        Route::get('/', [BlogController::class, 'getList']);
        Route::get('/tag/{tag}', [BlogController::class, 'getByTag']);
        Route::get('/search/{search}', [BlogController::class, 'search']);
        Route::get('/slugs', [BlogController::class, 'getSlugs']);
        Route::get('/total-pages', [BlogController::class, 'getTotalPages']);
        Route::get('/latest', [BlogController::class, 'getLatest']);
        Route::get('/{slug}', [BlogController::class, 'getBySlug']);
    });

    Route::get('tags', [TagController::class, 'getAll']);
});

Route::post('newsletter/signup', [NewsletterController::class, 'signUp']);

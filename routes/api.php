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
        Route::get('/', [BlogController::class, 'getList'])->name('blog.list');
        Route::get('/tag/{tag}', [BlogController::class, 'getByTag'])->name('blog.tag');
        Route::get('/search/{search}', [BlogController::class, 'search'])->name('blog.search');
        Route::get('/slugs', [BlogController::class, 'getSlugs'])->name('blog.slugs');
        Route::get('/{slug}', [BlogController::class, 'getBySlug'])->name('blog.get');
    });

    Route::get('tags', [TagController::class, 'getAll'])->name('tag.list');
});

Route::post('newsletter/signup', [NewsletterController::class, 'signUp'])->name('newsletter.signup');

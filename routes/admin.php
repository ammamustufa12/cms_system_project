<?php

use Illuminate\Support\Facades\Route;
use A17\Twill\Facades\TwillRoutes;

Route::group(['prefix' => 'admin', 'middleware' => ['web', 'twill.auth']], function () {
    // Twill modules
    TwillRoutes::module('pages');
    TwillRoutes::module('posts');
    // Add your own modules here

    // Custom routes (optional)
    // Route::get('custom-dashboard', [CustomDashboardController::class, 'index'])->name('admin.custom.dashboard');
});

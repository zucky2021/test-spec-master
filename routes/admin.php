<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Middleware\EnsureIsAdmin;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->middleware(['auth', 'verified', EnsureIsAdmin::class])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
});

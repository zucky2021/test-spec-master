<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Ajax\Admin\UserController as AjaxUserController;
use App\Http\Middleware\EnsureIsAdmin;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->middleware(['auth', 'verified', EnsureIsAdmin::class])->name('admin')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('.dashboard');
    Route::prefix('users')->name('.users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('');
        Route::get('/ajax', [AjaxUserController::class, 'index'])->name('.ajax');
        Route::patch('/update/ajax', [AjaxUserController::class, 'update'])->name('.update.ajax');
    });
    Route::get('/projects', [ProjectController::class, 'index'])->name('projects');
});
